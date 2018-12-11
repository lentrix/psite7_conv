<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Participant */

$this->title = 'Update Participant';
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member->fullName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$convention = \app\models\Convention::getActive();

$rooms = \app\models\Room::find()
	->where(['convention_id'=>$convention->id])
	->orderBy('name')->all();

$model->convention_id=$convention->id;
?>
<div class="participant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

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
