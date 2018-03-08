<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Participant */
/* @var $form yii\widgets\ActiveForm */

$convention = \app\models\Convention::getActive();
if($convention) $model->convention_id=$convention->id;

$rooms = \app\models\Room::findBySql("SELECT * FROM room WHERE convention_id=:cid AND occupants<capacity",
    [':cid'=>$convention->id]
)->all();

$participants = \app\models\Participant::find()
	->where(['convention_id'=>$convention->id])
	->all();

$sql = "SELECT * FROM members WHERE active=:status AND id NOT IN (SELECT member_id FROM participant WHERE convention_id=:conventionId)";
$members = \app\models\Member::findBySql($sql, [':status'=>1, ':conventionId'=>$convention->id])->all();

?>

<div class="participant-form">

    <?php $form = ActiveForm::begin(['action'=>['participant/create']]); ?>

    <?= $form->field($model, 'convention_id')->hiddenInput()->label(''); ?>

    <?= $form->field($model, 'member_id')->dropDownList(
    	ArrayHelper::map($members, 'id','fullName'),
    	['prompt'=>'Select member']
    ) ?>

    <?= $form->field($model, 'room_id')->dropDownList(
    	ArrayHelper::map($rooms, 'id','name'),
    	['prompt'=>'Stay Out']
    ) ?>

    <?= $form->field($model, 'role')->dropDownList(
    	['Delegate'=>'Delegate', 'Presentor'=>'Presentor','Sponsor'=>'Sponsor'],
    	['prompt'=>'Select role']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
