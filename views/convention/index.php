<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConventionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Conventions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="convention-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Convention', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_start',
            'date_end',
            'venue',
            'host_school',
            //'chair',
            //'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
