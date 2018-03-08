<?php 
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = "Rooms Available";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pull-right">
	<?php Modal::begin([
		'header'=>'<h3>Add Room</h3>',
		'id' => 'modal-create-member',
		'toggleButton' => [
			'label'=>'<i class="glyphicon glyphicon-plus"></i>',
			'class'=>'btn btn-primary pull-right',
			'title' => 'Add Room',
		],
	]); ?>
		<?= $this->render('/convention/room-form.php',compact('room')); ?>
	<?php Modal::end(); ?>
</div>
<h1><?= $this->title ?></h1>
<p>
	<?= $model->series ?> PSITE7 Convention @ <?= $model->venue ?>
</p>
<?php if (count($model->rooms)==0): ?>
	<p>No rooms yet. </p>
<?php endif ?>

<?php foreach($model->rooms as $room): ?>
<div class="col-md-3 col-sm-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="pull-right">
				<?= Html::a('<i class="glyphicon glyphicon-open"></i>', 
					['/convention/view-room', 'id'=>$room->id],
					['class'=>'btn btn-primary btn-xs']); ?>
			</span>
			<strong><?= $room->name ?></strong>
		</div>
		<div class="panel-body">
			<table class="table table-bordered table-striped">
				<tr>
					<td>capacity</td><td><?= $room->capacity?></td>
				</tr>
				<tr>
					<td>No. of Occupants</td><td><?= count($room->participants)?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?php endforeach; ?>

