<?php

namespace app\controllers;

use Yii;
use app\models\Convention;
use app\models\ConventionSearch;
use app\models\Room;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;

/**
 * ConventionController implements the CRUD actions for Convention model.
 */
class ConventionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'only' => ['index','view','create','update','delete','view-staty-out'],
                'rules' => [
                    [
                        'actions'=>['index','view','create','update','delete','view-stay-out'],
                        'roles'=>[1],
                        'allow'=>true
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Convention models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConventionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Convention model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewStayOut()
    {
        $convention = Convention::getActive();

        if($convention==null) {
            return $this->redirect(['/site/index']);
        }

        $participants = \app\models\Participant::find()
            ->where(['convention_id'=>$convention->id])
            ->andWhere(['room_id'=>null])
            ->all();

        return $this->render('view-stay-out', compact('participants'));
    }

    /**
     * Creates a new Convention model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Convention();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Convention model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Convention model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRooms($id) 
    {
        $model = $this->findModel($id);
        $room = new Room();
        $room->convention_id = $model->id;

        if($room->load(Yii::$app->request->post()) && $room->validate()) {
            $room->save();
            return $this->redirect(['/convention/rooms', 'id'=>$id]);
        }

        return $this->render('rooms',['model'=>$model,'room'=>$room]);
    }

    public function actionViewRoom($id) {
        $room = Room::findOne($id);

        if($room->load(Yii::$app->request->post()) && $room->save()) {
            return $this->redirect(['/convention/view-room','id'=>$id]);
        }

        return $this->render('view-room',compact('room'));
    }

    public function actionActivate($id) {
        $this->findModel($id)->setAsActive();
        Yii::$app->session->setFlash('info', 'This convention has changed status to active.');
        return $this->redirect(['/convention/view','id'=>$id]);
    }

    /**
     * Finds the Convention model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Convention the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Convention::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
