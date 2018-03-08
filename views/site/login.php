<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "User Login";

?>

<br><br>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="well">
            <h1><?=$this->title?></h1>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="row">
                    <div class="col-sm-8">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                    <div class='col-sm-4'>
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
</div>
<br><br><br><br><br>