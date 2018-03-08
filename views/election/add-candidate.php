<?php 
use yii\helpers\Html;

$this->title = "Add a candidate";
$this->params['breadcrumbs'][] = ['label'=>'Election Manager', 'url'=>['/election/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= $this->title ?></h1>
<?php foreach($participants as $p): ?>
	<div class="col-md-4">
		<div class="well">
			<span class="pull-right">
				<?= Html::a('<i class="glyphicon glyphicon-plus"></i>',
					['/election/add','election_id'=>$election->id,'participant_id'=>$p->id],
					['class'=>'btn btn-primary btn-sm']
				)?>
			</span>
			<div class="large-text"><?= $p->member->fullName ?></div>
			<i><?= $p->member->designation ?> | <?= $p->member->school ?></i>
		</div>
	</div>
<?php endforeach; ?>