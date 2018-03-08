<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

if(isset($page)) {
	$action = ['/member/create','page'=>$page];
}else {
	$action = ['/member/create'];
}

?>

<?php $form = ActiveForm::begin(['action'=>$action]) ?>

<?= $form->field($member, 'email') ?>

<?= $form->field($member, 'password')->passwordInput() ?>

<?= $form->field($member, 'lname') ?>

<?= $form->field($member, 'fname') ?>

<?= $form->field($member, 'nickname') ?>

<?= $form->field($member, 'school') ?>

<?= $form->field($member, 'designation') ?>

<?= $form->field($member, 'phone') ?>

<div class="form-group" style="text-align: center">
	<?= Html::submitButton('Create Member', ['class'=>'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>