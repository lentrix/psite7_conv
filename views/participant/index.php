<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participants';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function(){    
    $(".clickable").click(function(){
        document.location = $(this).attr('value');
    });
});
JS;

$this->registerJS($script);
?>
<div class="participant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Participant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'member_id', 'value'=>'member.fullName'],
            ['attribute'=>'room_id', 'value'=>'room.name'],
            'role',
            
        ],
        'rowOptions' => function($model, $key, $index, $grid) {
            return [
                'style' => 'cursor: pointer',
                'value' => Url::toRoute(['/participant/view','id'=>$model->id]),
                'class' => 'clickable',
            ];
        },
        'tableOptions' => [
            'class'=>'table table-striped table-bordered table-hover'
        ],
    ]); ?>
</div>
