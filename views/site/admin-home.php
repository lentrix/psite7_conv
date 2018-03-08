<?php 
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = Yii::$app->name . " | Home";

$memberCount = \app\models\Member::find()->where(['active'=>1])->count();

?>

<h1>Dashboard</h1>

<div class="row">
	<div class="col-md-6 col-sm-6">
		<?php if($convention!=NULL) :?>
		<div class="well">
			<h2>
				<?= Html::a('<i class="glyphicon glyphicon-plus"></i>', 
					['/convention/create'],
					[
						'class'=>'btn btn-sm btn-primary pull-right', 
						'title'=>'Create a new convention'
					]) ?>
				<?= Html::a('<i class="glyphicon glyphicon-list"></i>',
				['/convention/index'],
				[
					'class'=>'btn btn-info btn-sm pull-right',
					'style'=>'margin-right: 5px',
					'title' => 'View Conventions List',
				]);?>
				Convention
			</h2>
			<table class="table">
				<tr>
					<th valign="top">Venue</th><td><?=$convention->venue?></td>
				</tr>
				<tr>
					<th>Date</th><td><?= date('F d, Y',strtotime($convention->date_start))?> 
						- <?= date('F d, Y',strtotime($convention->date_end))?> </td>
				</tr>
				<tr>
					<th>Host School</th><td><?= $convention->host_school?></td>
				</tr>
				<tr>
					<th>Convention Chair</th><td><?=$convention->chair?></td>
				</tr>
				<tr>
					<th>Available Rooms</th>
					<td>
						<?= count($convention->rooms) ?>
						<span class="pull-right">
							<?= Html::a('<i class="glyphicon glyphicon-list"></i> View Rooms', 
								['convention/rooms','id'=>$convention->id],
								['title'=>'View Rooms','class'=>'btn btn-primary']); ?>
						</span>
					</td>
				</tr>
			</table>
		</div>
		<?php else: ?>
			<div>
				No active convention <br>
				<?= Html::a('List of Conventions',['/convention/index'], ['class'=>'btn btn-primary']); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if($convention!=null): ?>
	<div class="col-md-3 col-sm-3">
		<div class="well">
			<?php Modal::begin([
				'header'=>'<h3>Add Member</h3>',
				'id' => 'modal-create-member',
				'toggleButton' => [
					'label'=>'<i class="glyphicon glyphicon-plus"></i>',
					'class'=>'btn btn-sm btn-primary pull-right',
					'title' => 'Create Member',
				],
			]); ?>
				<?= $this->render('/member/create.php',compact('member')); ?>
			<?php Modal::end(); ?>
			<?= Html::a('<i class="glyphicon glyphicon-list"></i>',
				['/member/index'],
				[
					'class'=>'btn btn-info btn-sm pull-right',
					'style'=>'margin-right: 5px',
					'title' => 'View Members List',
				]);?>
			<h3>Members</h3>
			<div class="dashboard-count"><?= $memberCount; ?></div>
		</div>
	</div>

	<div class="col-md-3 col-sm-3">
		<div class="well">
			<?php Modal::begin([
				'header'=>'<h3>Register Participant</h3>',
				'id' => 'modal-create-participant',
				'toggleButton' => [
					'label'=>'<i class="glyphicon glyphicon-plus"></i>',
					'class'=>'btn btn-sm btn-primary pull-right',
					'title' => 'Register Participant',
				],
			]); ?>
				<?= $this->render('/participant/create.php',['model'=>new \app\models\Participant]); ?>
			<?php Modal::end(); ?>
			<?= Html::a('<i class="glyphicon glyphicon-list"></i>',
				['/participant/index'],
				[
					'class'=>'btn btn-info btn-sm pull-right',
					'style'=>'margin-right: 5px',
					'title' => 'View List of Participants'
				]);?>
			<h3>Participants</h3>
			<div class="dashboard-count">
				<?= count($convention->participants); ?>
			</div>
		</div>
	</div>

	<?php endif; ?>
</div>
