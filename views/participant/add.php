<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Room;

$rooms = \app\models\Room::findBySql("SELECT * FROM room WHERE convention_id=:cid AND occupants<capacity",
    [':cid'=>$model->convention_id]
)->all();
?>

<?php $form = ActiveForm::begin() ?>

<?= $form->errorSummary($model) ?>

<?= $form->field($model, 'room_id')->dropDownList(
	ArrayHelper::map($rooms,'id','name'),
	['prompt'=>'Stay Out']
) ?>

<?= $form->field($model, 'role')->dropDownList(
	['Delegate'=>'Delegate', 'Presentor'=>'Presentor', 'Sponsor'=>'Sponsor'],
	['prompt'=>'Select role']
) ?>

<div class="form-group">
	<?= Html::submitButton('Submit',['class'=>'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>