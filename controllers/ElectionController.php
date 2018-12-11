<?php

namespace app\controllers;

use Yii;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\Election;
use app\models\Convention;
use app\models\Participant;
use app\models\Candidate;
use app\models\Ballot;
use app\models\Vote;
use yii\filters\VerbFilter;
use yii\base\ErrorException;


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
				'only'=>['index','eligible','nominate','vote','admin-home',
               'member-home','result','toggle-eligible','change-status',
               'nomination','election-start','done','device-authorize',
               'remove-device-authority'
            ],
				'rules' => [
					[
						'actions'=>['index','nominate','vote','member-home',
                     'result','nomination','done'],
						'allow'=>true,
						'roles'=>['@']
					],
					[
						'actions' =>[
                     'eligible','admin-home','toggle-eligible','change-status',
                     'election-start','device-authorize','remove-device-authority' 
                  ],
						'allow'=>true,
						'roles' => [1]
					]
				]
			],
			'verbs' => [
             'class' => VerbFilter::className(),
             'actions' => [
                 'remove-candidate' => ['POST'],
                 'device-authorize' => ['post']
             ],
         ],
		];
	}

   public function actionIndex()
   {
   	if(Yii::$app->user->identity->role==1) {
         return $this->redirect(['/election/admin-home']);
      }else {
         return $this->redirect(['/election/member-home']);
      }
   }

   public function actionMemberHome()
   {
      $election = Convention::getActive()->election;
      if($election==null || $election->status==0){
         return $this->render('member-home', compact('election'));
      }else {
         switch($election->status){
            case Election::STATUS_NOMINATION : return $this->redirect(['/election/nominate']);
            case Election::STATUS_ON_GOING : return $this->redirect(['/election/vote']);
            case Election::STATUS_CLOSED : return $this->redirect(['/election/result']);
         }
      }
   }

   public function actionAdminHome()
   {
      $convention = Convention::getActive();
      
      if($convention==null) {
         throw new \yii\web\NotFoundHttpException("There is no active convention.");
      }

      $election = $convention->election;
      if($election==null) {
         return $this->render('admin-home', compact('election'));
      }else {
         switch($election->status){
            case Election::STATUS_PREP : return $this->redirect(['/election/eligible']);
            case Election::STATUS_NOMINATION : return $this->redirect(['/election/nominate']);
            case Election::STATUS_ON_GOING : return $this->redirect(['/election/vote']);
            case Election::STATUS_CLOSED : return $this->redirect(['/election/result']);
         }
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

   public function actionEligible()
   {
      $participants = Participant::find()
         ->joinWith('member')
         ->where(['convention_id'=>Convention::getActive()->id])
         ->orderBy('lname, fname')
         ->all();

      return $this->render('eligible', compact('participants'));
   }

   public function actionNominate() {
      $participant = Yii::$app->user->identity->currentParticipation;
      $conventionId = Convention::getActive()->id;
      $eligibles = Participant::getEligibles();
      $nominees = Participant::getNominees();
      
      return $this->render('nominate', compact('eligibles','nominees','participant'));
   }

   public function actionNomination($id)
   {
      $participant = Yii::$app->user->identity->currentParticipation;
      
      if($participant==null) throw new \yii\web\UnauthorizedHttpException("You are not a participant of the current convention.");

      $participant->nominated = $id;
      $participant->save();
      return $this->redirect(['/election/nominate']);
   }

   public function actionElectionStart()
   {
      $election = Convention::getActive()->election;
      if($election->status == Election::STATUS_ON_GOING) {
         Yii::$app->session->setFlash('info', 'Election has already started.');
         return $this->redirect(['/election/vote']);
      }
      $nominees = Participant::getNominees();
      $this->createCandidates($nominees);

      return $this->redirect(['/election/change-status','value'=>Election::STATUS_ON_GOING]);
   }

   public function actionDone()
   {
      return $this->render('done');
   }

   public function actionToggleEligible($id)
   {
      $participant = Participant::findOne($id);
      $participant->eligible = $participant->eligible?0:1;
      $participant->save();
      return $this->redirect(['/election/eligible']);
   }

   public function actionAuthorizeDevice() {
      $cookies = Yii::$app->response->cookies;
      $code = Yii::$app->getSecurity()->generateRandomString();
      $cookies->add(new \yii\web\Cookie([
         'name' => 'authorization_code',
         'value' => $code
      ]));
      $cookies->add(new \yii\web\Cookie([
         'name' => 'authorization_hash',
         'value' => Yii::$app->getSecurity()->hashData($code, Yii::$app->name)
      ]));

      return $this->redirect(['/election/vote']);
   }

   public function actionVote()
   {

      $election = Convention::getActive()->election;
      $participant = Yii::$app->user->identity->currentParticipation;

      // if(!$this->isDeviceAuthorized()) {
      //    return $this->render('authorize');
      // }

      if($participant->has_voted) return $this->redirect(['election/done']);
      
      if($election==null) throw new ErrorException("No Active Election");

      $candidates = Candidate::find()
         ->with('member')
         ->where(['election_id'=>$election->id])
         ->all();

      $ballot = new Ballot;

      if($ballot->load(Yii::$app->request->post()) && $ballot->validate()){
         foreach($ballot->votes as $vt) {
            $vote = new Vote;
            $vote->participant_id = $participant->id;
            $vote->candidate_id = $vt;
            $vote->validation_hash = Yii::$app->security->hashData($vote->participant_id . $vote->candidate_id, Yii::$app->name);
            $vote->save();

            $participant->has_voted = 1;
            $participant->save();
         }
         return $this->redirect(['election/vote']);
      }

      return $this->render('vote',compact('ballot','candidates'));
   }

   public function actionChangeStatus($value)
   {
   	$model = Convention::getActive()->election;

      if($value == Election::STATUS_ON_GOING){
         $model->start = date('Y-m-d h:i:s');
         $model->started_by = Yii::$app->user->identity->id;
      }

      if($value == Election::STATUS_CLOSED){
         $model->end = date('Y-m-d h:i:s');
         $model->ended_by = Yii::$app->user->identity->id;
      }

   	$model->status = $value;
   	$model->save();
   	Yii::$app->session->setFlash('info','Election status changed.');
   	return $this->redirect(['/election/index']);
   }

   public function actionResult()
   {
      $this->cleanVotes();
      $election = Convention::getActive()->election;
      $no_of_winners = $election->no_of_winners;
      $results = [];
      $candidates = Candidate::find()->joinWith('member')->where(['election_id'=>$election->id])->all();

      foreach($candidates as $candidate) {
         $results[$candidate->member->fullName] =  Vote::find()->where(['candidate_id'=>$candidate->id])->count();
      }

      arsort($results);

      return $this->render('result', compact('results','no_of_winners'));
   }

   public function createCandidates($nominees) {
      $election = Convention::getActive()->election;
      
      if($election==null) throw new ErrorException("No Active Election");

      foreach($nominees as $nominee) {
         $candidate = new Candidate();
         $candidate->election_id = $election->id;
         $candidate->participant_id = $nominee->id;
         $candidate->save();
      }
   }

   private function cleanVotes()
   {
      $votes = Vote::find()->all();
      foreach($votes as $vote) {
         $hash = Yii::$app->security->hashData($vote->participant_id . $vote->candidate_id, Yii::$app->name);
         if($vote->validation_hash!==$hash) {
            $vote->delete();
         }
      }
   }

   private function isDeviceAuthorized() {
      $cookies =  Yii::$app->request->cookies;
      if($cookies->has('authorization_hash')) {
         $authorization_hash = $cookies->getValue('authorization_hash');         
         return Yii::$app->security->validateData($authorization_hash, Yii::$app->name);
      }else {
         return false;
      }
   }

   public function actionDeviceAuthorize() {
      $cookies = Yii::$app->response->cookies;
      
      $code = Yii::$app->security->generateRandomString(45);

      $cookies->add(new \yii\web\Cookie([
         'name' => 'authorization_code',
         'value' => $code
      ]));
      $cookies->add(new \yii\web\Cookie([
         'name' => 'authorization_hash',
         'value' => Yii::$app->security->hashData($code, Yii::$app->name)
      ]));

      Yii::$app->session->setFlash('info', 'This device has been authorized for voting.');

      return $this->redirect(['/election/vote']);
   }

   public function actionRemoveDeviceAuthority() {
      $cookies = Yii::$app->response->cookies;

      $cookies->remove('authorization_code');
      $cookies->remove('authorization_hash');

      Yii::$app->session->setFlash('warning', 'Voting Authority for this device has been removed.');

      return $this->redirect(['/election/vote']);
   }

}
