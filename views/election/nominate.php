<?php 
use yii\helpers\Html;
use app\models\Election;

$this->title = "Election | Nomination Phase";
$this->params['breadcrumbs'][] = $this->title;

?>

<?php if(Yii::$app->user->identity->role==1): ?>

	<?= Html::a('Commence Election Phase <i class="glyphicon glyphicon-arrow-right"></i>', 
		['/election/election-start'],
		['class'=>'btn btn-warning pull-right']
	) ?>

<?php endif; ?>

<h1><?= $this->title ?></h1>
<?php if(!$participant->nominated): ?>
<div class="row">
	<div class="col-md-12">
		<?php if(count($eligibles)==0) : ?>
			<p class="alert alert-info">All eligible participants have been nominated.</p>
		<?php else: ?>
		<h3>Eligible for Nomination</h3>
		<p>Please click on the <i class="glyphicon glyphicon-thumbs-up"></i> icon to nominate a candidate.</p>
		<?php endif; ?>
	</div>

	<?php foreach($eligibles as $eligible): ?>
		<div class="col-md-3">
			<div class="well">
				<span class="pull-right">
					<?= Html::a('<i class="glyphicon glyphicon-thumbs-up"></i>', 
						['/election/nomination', 'id'=>$eligible->id],
						['class'=>'btn btn-primary btn-sm','title'=>"Nominate"]
					) ?>
				</span>
				<span class="large-text">
					<?= $eligible->member->fullName ?>
				</span><br>
				<span style="color: #1973a9">
					<i class="glyphicon glyphicon-user"></i> <i><?= $eligible->member->designation ?><br>
					<i class="glyphicon glyphicon-home"></i> <i><?= $eligible->member->school ?></i>
				</span>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<?php else: ?>
	<?php $myNominated = \app\models\Participant::findOne($participant->nominated) ?>
	<div class="alert alert-info">
		You have nominated <?= $myNominated->member->fullName ?> of <?= $myNominated->member->school ?>
	</div>
<?php endif; ?>

<hr>

<div class="row">
	<div class="col-md-12"><h3>List of Nominees</h3></div>
	<?php foreach($nominees as $nominee): ?>
		<div class="col-md-3">
			<div class="well">
				
				<span class="large-text">
					<?= $nominee->member->fullName ?>
				</span><br>
				<span style="color: #1973a9">
					<i class="glyphicon glyphicon-user"></i> <i><?= $nominee->member->designation ?><br>
					<i class="glyphicon glyphicon-home"></i> <i><?= $nominee->member->school ?></i>
				</span>
			</div>
		</div>
	<?php endforeach; ?>
</div>
</div>
