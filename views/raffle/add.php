<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<h1><?= $this->title; ?></h1>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'prize')->textInput() ?>

<?php ActiveForm::end(); ?>