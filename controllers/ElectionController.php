<?php

namespace app\controllers;

use Yii;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\Election;
use app\models\Convention;
use yii\filters\VerbFilter;

class ElectionController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'access'=>[
				'class'=>AccessControl::className(),
				'ruleConfig'=>[
					'class'=>AccessRule::className(),
				],
				'only'=>['index','create'],
				'rules' => [
					[
						'actions'=>['index'],
						'allow'=>true,
						'roles'=>['@']
					],
					[
						'actions' =>['create'],
						'allow'=>true,
						'roles' => [1]
					]
				]
			],
			'verbs' => [
             'class' => VerbFilter::className(),
             'actions' => [
                 'remove-candidate' => ['POST'],
             ],
         ],
		];
	}

   public function actionIndex()
   {
   	$model = Convention::getActive()->election;
   	$candidates = \app\models\Candidate::find()
   			->with(['participant'=>function($query){
   				$query->joinWith('member')->orderBy('lname, fname');
   			}])
   			->where(['election_id'=>$model->id])
   			->all();

   	if(Yii::$app->user->identity->role===1) {
   		return $this->render('index-admin',compact('model','candidates'));
   	}else {
   		return $this->render('index', compact('model','candidates'));
   	}
   }

   public function actionCreate()
   {
   	$model = new Election;
   	$model->convention_id = Convention::getActive()->id;

   	if($model->load(Yii::$app->request->post()) && $model->save()) {
   		return $this->redirect(['/election/index']);
   	}
   	return $this->render('create', ['model'=>$model]);
   }

   public function actionAdd($election_id, $participant_id=0)
   {
   	if($participant_id) {
   		$candidate = new \app\models\Candidate;
   		$candidate->election_id = $election_id;
   		$candidate->participant_id = $participant_id;
   		if(!$candidate->save()) {
   			die("Error!" . $candidate->participant_id);
   		}
   		Yii::$app->session->setFlash('info', 'A candidate has been added.');
   		return $this->redirect(['/election/index']);
   	}else {
   		
   		$election = \app\models\Election::find()
   			->joinWith('convention')
   			->where(['election.id'=>$election_id])->one();

   		$candidatesParticipantId = (new \yii\db\Query())
   			->select('participant_id')
   			->from('candidate')
   			->where(['election_id'=>$election->id]);

   		$participants = \app\models\Participant::find()
   			->joinWith('member')
   			->where(['convention_id'=>$election->convention->id])
   			->andWhere(['not in', 'participant.id', $candidatesParticipantId])
   			->orderBy('lname, fname')
   			->all();

   		return $this->render('add-candidate', compact('participants','election'));
   	}
   }

   public function actionRemoveCandidate($candidate_id) {
   	$candidate = \app\models\Candidate::findOne($candidate_id);
   	$name = $candidate->participant->member->fullName;
   	$candidate->delete();
   	Yii::$app->session->setFlash('warning',"The candidacy of $name has been removed.");
   	return $this->redirect(['/election/index']);
   }

   public function actionChangeStatus($id, $value)
   {
   	$model = \app\models\Election::findOne($id);
   	$model->status = $value;
   	$model->save();
   	Yii::$app->session->setFlash('info','Election status changed.');
   	return $this->redirect(['/election/index']);
   }
}
