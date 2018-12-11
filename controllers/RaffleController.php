<?php

namespace app\controllers;

use yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;

use app\models\Convention;
use app\models\Raffle;
use app\models\PredrawForm;
use app\models\Participant;

class RaffleController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'only' => ['index','add','draw','register-winner', 'duplicate'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'roles'=>['@'],
                        'allow'=> true
                    ],
                    [
                    	'actions' => ['add', 'draw', 'register-winner','duplicate'],
                    	'allow' => true,
                    	'roles' => [1]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

    	$convention = Convention::getActive();

        $dataProvider = new \yii\data\ActiveDataProvider(
        	[
        		'query' => Raffle::find()->where(['convention_id'=>$convention->id]),
        		'sort' => [
        			'defaultOrder' => ['drawn'=>SORT_ASC]
        		],
        	]
        );

        $drawables = Raffle::find()->where(['drawn'=>null])->orderBy('prize')->all();

        return $this->render('index', compact('dataProvider','drawables'));
    }

    public function actionAdd() {
    	$model = new Raffle;
    	$model->convention_id = Convention::getActive()->id;
    	$model->created_by = Yii::$app->user->id;

    	if($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['/raffle/index']);
    	}

    	return $this->render('add', compact('model'));
    }

    public function actionDraw()
    {
    	$preDrawForm = new PredrawForm;
    	if($preDrawForm->load(Yii::$app->request->post()) && $preDrawForm->validate()) {
    		$raffle = Raffle::findOne($preDrawForm->raffle_id);
    		
    		if($preDrawForm->exclusive) {
    			$winningIds =  (new \yii\db\Query())
                    ->select(['participant_id'])
                    ->from('raffle')
                    ->where(['not', 'drawn IS NULL']);

		        $participants = \app\models\Participant::find()
            		->where(['not in', 'id', $winningIds])->with('member');
    		}else {
    			$participants = Participant::find()->with('member');
    		}
    	}else {
    		Yii::$app->session->setFlash('warning', 'Lacking Predraw information');
    		return $this->redirect(['/raffle/index']);
    	}

    	$drawables = [];
    	foreach($participants->all() as $p) {
    		$drawables[] = [
    			'participant_id' => $p->id,
    			'full_name' => $p->member->fullName,
    			'school' => $p->member->school
    		];
    	}

    	shuffle($drawables);

    	return $this->render('draw', ['raffle'=>$raffle, 
    		'participants'=>\yii\helpers\BaseJson::encode($drawables)]);
    }

    public function actionRegisterWinner() {
    	$raffle_id = $_POST['raffle_id'];
    	$participant_id = $_POST['participant_id'];

    	$raffle = Raffle::findOne($raffle_id);
    	$raffle->participant_id = $participant_id;
    	$raffle->drawn = date('Y-m-d h:i:s');
    	$raffle->save();

    	return $this->redirect(['/raffle/index']);
    }

    public function actionDuplicate($id)
    {
    	$raffle = Raffle::findOne($id);
    	$duplicate = new Raffle;
    	$duplicate->prize = $raffle->prize;
    	$duplicate->created_by = Yii::$app->user->id;
    	$duplicate->convention_id = $raffle->convention_id;

    	$duplicate->save();

    	return $this->redirect(['/raffle/index']);
    }

}
