<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->title ="Election | Voting Phase";
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function(){
	$('.candidate-item-check').change(function(){
		$(this).parent().toggleClass('active');
	});
});
JS;

$this->registerJS($script);
?>

<style>
	.candidate-label {
		font-size: 1.3em;
	}
	
</style>

<?php if (Yii::$app->user->identity->role==1): ?>
	
<div class="pull-right">
	<?= Html::a('<i class="glyphicon glyphicon-lock"></i> Remove Device Authority', ['/election/remove-device-authority'], 
		[
			'class' => 'btn btn-lg btn-primary'
		]
	) ?>
</div>

<?php endif ?>

<h1><?= $this->title ?></h1>

<div class="row">
	<div class="col-md-6">
		<div class="alert alert-warning">
			<h3>Notice</h3>
			<p>
				This page is your personal online ballot.
				It is your prerogative to cast your vote secretly.
				You are therefore advised to cast your vote
				secretly, and privately. Please don't let other
				people view your device while casting your vote.
			</p>
		</div>
	</div>
	<div class="col-md-6">
		<?php $form = ActiveForm::begin() ?>
		
		<p>
			<strong>Please select your candidate</strong><br>
			<span style="color: #888; font-style: italic;">
				You may select up to <?= \app\models\Convention::getActive()->election->no_of_winners ?>
				candidates.
			</span>
		</p>

		<?= $form->field($ballot, 'votes')->checkBoxList(
			ArrayHelper::map($candidates, 'id','member.fullName'),
			['item'=>function($index, $label, $name, $checked, $value){
				return "<label class='list-group-item candidate-label'>
				<i></i> $label <input type='checkbox' name='$name' value='$value' class='candidate-item-check pull-right' data-id='$index'></label>";
			}]
		)->label(false) ?>

		<p style="font-style: italic; color: #888">Please double check your selection before you proceed.</p>

		<div class="form-group">
			<?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Cast My Vote', ['class'=>'btn btn-primary btn-lg']) ?>
		</div>

		<?php ActiveForm::end() ?>
	</div>
</div>