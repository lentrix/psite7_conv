<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "User Registration";

?>

<h1>Registration Form</h1>
<hr>

<div class="row">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true,'type'=>'email']) ?>

        <?= $form->field($model, 'password')->textInput(['type'=>'password']); ?>

        <?= $form->field($model, 'password_repeat')->textInput(['type'=>'password']); ?>

        <hr>

        <?= $form->field($model, 'lname')->textInput(); ?>

        <?= $form->field($model, 'fname')->textInput(); ?>

        <?= $form->field($model, 'nickname')->textInput(); ?>

        <?= $form->field($model, 'school')->textInput(); ?>

        <?= $form->field($model, 'designation')->textInput(); ?>

        <?= $form->field($model, 'phone')->textInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Register',['class'=>'btn btn-primary btn-lg pull-right']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>You are welcome to join!</h3>
            </div>
            <div class="panel-body">
                <p>
                    PSITE-7 Welcomes all interested IT/CS educators and practitioners to join our
                    annual Regional Convention. Please feel free to fill out the Registration Form 
                    to join this year's PSITE-7 Regional Convention at Dumaguete city, Philippines.
                </p>
            </div>
        </div>
        
    </div>
</div>
