<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Convention */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="convention-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'series')->textInput(['maxlength' => true,'placeholder'=>'1st, 2nd, etc.']) ?>

    <?= $form->field($model, 'date_start')->widget(
        DatePicker::className(), [
            // inline too, not bad
             'inline' => false, 
             // modify template for custom rendering
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
    ]);?>

    <?= $form->field($model, 'date_end')->widget(
        DatePicker::className(), [
            // inline too, not bad
             'inline' => false, 
             // modify template for custom rendering
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
    ]);?>

    <?= $form->field($model, 'venue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'host_school')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chair')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
