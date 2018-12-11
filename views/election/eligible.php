<?php 
use yii\helpers\Html;
use app\models\Election;

$this->title = "Eligibility for Nomination";
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::a('Commence Nomination Phase <i class="glyphicon glyphicon-arrow-right"></i>', 
	['/election/change-status','value'=>Election::STATUS_NOMINATION],
	['class'=>'btn btn-warning pull-right']
) ?>

<h1><?= $this->title ?></h1>

<div class="row">
	<?php foreach([0=>'Not Eligible',1=>'Eligible'] as $e=>$eligibility): ?>
		<div class="col-md-6">
			<h2><?= $eligibility ?></h2>
			<div class="list-group">
				<?php foreach($participants as $ne): ?>
					<?php if($ne->eligible==$e): ?>
						<div class="list-group-item">
							<?= $ne->member->fullName ?>
							<span class="pull-right">
								<?php $direction = $e==0?'right':'left' ?>
								<?= Html::a('<i class="glyphicon glyphicon-arrow-' . $direction . '"></i>',
									['/election/toggle-eligible','id'=>$ne->id],
									['class'=>'btn btn-default btn-xs','title'=>$e==0?'Make Eligible':'Make Non Eligible']
								) ?>
							</span>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
	