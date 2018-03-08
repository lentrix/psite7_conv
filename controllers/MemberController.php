<?php

namespace app\controllers;
use yii;
use app\models\Member;
use app\models\MemberSearch;
use app\components\AccessRule;
use yii\filters\AccessControl;

class MemberController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className()
                ],
                'only' => ['index', 'change-password', 'create', 'update', 'view','toggle-active'],
                'rules' => [
                    [
                        'actions'=>['index','view'],
                        'roles' => ['@'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['change-password', 'create', 'update','toggle-active'],
                        'roles' => [1],
                        'allow' => true
                    ]
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        if(Yii::$app->user->identity->role==2) {
            return $this->redirect(['/member/view','id'=>Yii::$app->user->id]);
        }
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',compact('dataProvider', 'searchModel'));
    }

    public function actionChangePassword()
    {
        return $this->render('change-password');
    }

    public function actionCreate($page='')
    {
        $member = new Member;
        if($member->load(Yii::$app->request->post()) && $member->validate() ) {
            $member->setPassword($member->password);
            $member->save();
            Yii::$app->session->setFlash('info','A new member has been added.');
            if(!$page) {
                return $this->redirect(['/site/index']);    
            }else {
                return $this->redirect([$page]);
            }
            
        }
        return $this->render('create');
    }

    public function actionUpdate($id)
    {
        if(Yii::$app->user->identity->id!==$id && Yii::$app->user->identity->role!==1) {
            Yii::$app->session->setFlash('error','You are not allowed to update this.');
            return $this->redirect(['/member/view', 'id'=>$id]);
        }
        $model = Member::findONe($id);
        $password = $model->password;

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->password !== $password) {
                $model->setPassword($model->password);
            }

            $model->save();
            Yii::$app->session->setFlash('info', "The account of $model->fname $model->lname has been updated.");
            return $this->redirect(['/member/view','id'=>$model->id]);
        }

        return $this->renderAjax('update', compact('model'));
    }

    public function actionView($id)
    {
        $model = Member::findOne($id);
        $convention = \app\models\Convention::getActive();
        $participant = new \app\models\Participant;

        $participant->member_id = $model->id;
        $participant->convention_id = $convention->id;

        if($participant->load(Yii::$app->request->post()) && $participant->save()) {
            Yii::$app->session->setFlash('info','Member has been added as participant.');
            $convention->updateRoomsOccupants();
            $model->active=true;
            $model->save();
            return $this->redirect(['/member/view', 'id'=>$id]);
        }

        return $this->render('view',['model'=>$model, 'participant'=>$participant]);
    }

    public function actionToggleActive($id) {
        $model = Member::findOne($id);
        if($model->active) {
            $model->active = false;
            $model->save();
            Yii::$app->session->setFlash('warning',"Member $model->fullname has been deactivated.");
        }else {
            $model->active = true;
            $model->save();
            Yii::$app->session->setFlash('success',"Member $model->fullname has been activated.");
        }
        return $this->redirect(['/member/view','id'=>$model->id]);
    }

}
