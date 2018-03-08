<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin(['action'=>['/member/update','id'=>$model->id]]);

echo $form->field($model, 'email')->textInput(['type'=>'email']);

echo $form->field($model, 'password')->passwordInput();

echo $form->field($model, 'lname')->textInput();

echo $form->field($model, 'fname')->textInput();

echo $form->field($model, 'nickname')->textInput();

echo $form->field($model, 'school')->textInput();

echo $form->field($model, 'designation')->textInput();

echo $form->field($model, 'phone')->textInput();

echo $form->field($model, 'role')->radioList(
		['1'=>'Administrator', '2'=>'User']
);

echo "<div class='form-group'>"	;
echo Html::submitButton('Update Member', ['class'=>'btn btn-primary']); 
echo "</div>";

ActiveForm::end();
?>