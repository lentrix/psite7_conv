<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Convention */

$this->title = $model->series . " Convention";
$this->params['breadcrumbs'][] = ['label' => 'Conventions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="convention-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Activate', ['activate', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date_start',
            'date_end',
            'venue',
            'host_school',
            'chair',
            'active',
        ],
    ]) ?>

</div>
