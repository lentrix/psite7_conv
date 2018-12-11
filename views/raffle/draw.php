<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title= "Raffle Draw";
$this->params['breadcrumbs'][] = ['label' => 'Raffle Draw', 'url'=>['/raffle/index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function(){    
	var data = $participants;
    
    var spinner = setInterval(function(){
    	obj = data[Math.floor(Math.random()*data.length)];
    	$('#full-name').text(obj.full_name);
    	$('#school').text(obj.school);
    	$('#count').text(i);
    },100);

    setTimeout(function(){
    	clearInterval(spinner);
    	$("#message").text("Congratulations to");
    	$('#result-window').addClass('confetti');
    	$('#buttons').css('display','inline-block');
    	$('#participant_id').attr('value', obj.participant_id);
    }, 3000);


});
JS;
$this->registerJS($script);
?>

<h1><?= $this->title; ?></h1>

<div class="alert alert-info">
	Raffle Draw for <?= $raffle->prize ?>
</div>

<div class="jumbotron" id="result-window">
	<span class="pull-right" id="buttons" style="display:none">
		<?= Html::beginForm(['/raffle/register-winner'], 'post') ?>
			<?= Html::a('Cancel / No-show', ['/raffle/index'], ['class'=>'btn btn-warning']);?>
			<input type="hidden" name="participant_id" value="" id="participant_id">
			<input type="hidden" name="raffle_id" value="<?= $raffle->id ;?>" id="raffle_id">
			<?= Html::submitButton('Register Winner',['class'=>'btn btn-success']); ?>
		<?= Html::endForm();?>
	</span>
	<h3 id="message"></h3>
	<h1 id="full-name"></h1>
	<h2 id="school"></h2>
	<p id="count"></p>
</div>


