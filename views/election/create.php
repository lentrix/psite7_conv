<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Election;

$this->title ="Create Election";
$this->params['breadcrumbs'][] = ['label'=>'Election', 'url'=>['/election/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="row">
	<div class="col-md-6">
		<?php $form=ActiveForm::begin() ?>

		<?= $form->field($model, 'election_officer')->textInput() ?>

		<?= $form->field($model, 'no_of_winners')->textInput(['type'=>'number']) ?>

		<div class="form-group">
			<?= Html::submitButton('Create Election',['class'=>'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>