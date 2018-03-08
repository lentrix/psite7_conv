<?php 
use yii\helpers\Html;
use app\models\Convention;
use yii\bootstrap\Modal;
use app\models\Election;

$this->title = "Election Manager";

$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title; ?></h1>

<?php if($model): ?>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="large-text">Candidates</span>
				<span class="pull-right">
					<?= Html::a('<i class="glyphicon glyphicon-plus"></i>',
						['/election/add','election_id'=>$model->id],
						['class'=>'btn btn-primary btn-sm','title'=>'Add candidate']
					); ?>
				</span>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
					<tr>
						<th>Name</th><th>Designation</th><th>School</th><th>&nbsp;</th>
					</tr>
					<?php foreach($candidates as $candidate): ?>
						<tr>
							<td><?= $candidate->participant->member->fullName ?></td>
							<td><?= $candidate->participant->member->designation ?></td>
							<td> <?= $candidate->participant->member->school ?></td>
							<td>
								<?= Html::a('<i class="glyphicon glyphicon-remove"></i>',
									['/election/remove-candidate','candidate_id'=>$candidate->id],
									[
										'class'=>'btn btn-danger btn-xs',
										'data' => [
											'confirm' => 'Are you sure you want to remove this candidate?',
											'method'=>['post']
										]
									]
								) ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
					
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="large-text">Election Status</span>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
					<tr>
						<th>Election Status:</th>
						<td>
							<?= $model->statusText ?>
							<span class="pull-right">
								<?php Modal::begin([
									'header'=>'<h3>Change Election Status</h3>',
									'id' => 'modal-change-election-status',
									'toggleButton' => [
										'label'=>'<i class="glyphicon glyphicon-list-alt"></i>',
										'class'=>'btn btn-sm btn-primary btn-xs',
										'title' => '',
									],
								]); ?>
									<?php $status = [ 
										Election::STATUS_PREP=>"Preparatory", 
										Election::STATUS_ON_GOING=>"On-Going",
										Election::STATUS_CLOSED=>"Closed"
									];?>

									<?php foreach($status as $key=>$st): ?>
										<?= Html::a($st,
											['/election/change-status','id'=>$model->id ,'value'=>$key],
											[
												'class'=>'btn btn-primary btn-block',
												'data'=>[
													'method'=>['post']
												]
											]
										)?>
									<?php endforeach; ?>

								<?php Modal::end(); ?>
							</span>
						</td>
					</tr>
					<tr>
						<th>No. of Candidates:</th><td><?= count($model->candidates) ?></td>
					</tr>
					<tr>
						<th>No. of Winners</th><td><?=$model->no_of_winners;?></td>
					</tr>
					<tr>
						<th>No. of Voters:</th><td><?= count($model->convention->participants) ?></td>
					</tr>
					<tr>
						<th>No. of Voters voted:</th>
						<td><?= \app\models\Participant::find()
							->where(['convention_id'=>$model->convention->id])
							->andWhere(['has_voted'=>1])->count()
						?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<?php else: ?>

<p>No election data.</p>
<p>
	<?= Html::a('Create Election', ['/election/create'],['class'=>'btn btn-primary']) ?>
</p>

<?php endif; ?>