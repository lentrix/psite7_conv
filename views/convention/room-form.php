<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin() ?>

<?= $form->field($room, 'name')->textInput() ?>

<?= $form->field($room, 'capacity')->textInput(['type'=>'number']); ?>

<div class="form-group">
	<?= Html::submitButton(' Save ', ['class'=>'btn btn-primary']); ?>
</div>

<?php ActiveForm::end() ?>