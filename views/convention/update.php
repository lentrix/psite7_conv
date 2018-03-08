<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Convention */

$this->title = 'Update ' . $model->series . " Convention";
$this->params['breadcrumbs'][] = ['label' => 'Conventions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="convention-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
