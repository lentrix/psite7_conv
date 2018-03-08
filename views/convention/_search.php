<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConventionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="convention-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_start') ?>

    <?= $form->field($model, 'date_end') ?>

    <?= $form->field($model, 'venue') ?>

    <?= $form->field($model, 'host_school') ?>

    <?php // echo $form->field($model, 'chair') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
