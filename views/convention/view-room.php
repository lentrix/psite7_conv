<?php 
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = "View Room";
$this->params['breadcrumbs'][] = ['label'=>'Rooms', 'url'=>['/convention/rooms','id'=>$room->convention->id]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function(){    
    $(".clickable").click(function(){
        document.location = $(this).attr('value');
    });
});
JS;

$this->registerJS($script);
?>
<div>
	<?php Modal::begin([
		'header'=>'<h3>Update Room</h3>',
		'id' => 'modal-create-member',
		'toggleButton' => [
			'label'=>'<i class="glyphicon glyphicon-edit"></i>',
			'class'=>'btn btn-primary pull-right',
			'title' => 'Update Room',
		],
	]); ?>
		<?= $this->render('/convention/room-form.php',compact('room')); ?>
	<?php Modal::end(); ?>
</div>
<h1><?= $this->title ?></h1>
<div class="row">
	<div class="col-md-4">
		<table class="table table-striped">
			<tr>
				<th>Name</th><td><?= $room->name;?></td>
			</tr>
			<tr>
				<th>Capacity</th><td><?= $room->capacity;?></td>
			</tr>
			<tr>
				<th>No. of occupants</th><td><?= count($room->participants);?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-8">
		<h2 style="margin:0px">List of Occupants</h2>
		<table class="table table-striped table-hover">
			<tr>
				<th>Name</th>
				<th>School</th>
				<th>Designation</th>
				<th>Role</th>
			</tr>
			<?php foreach($room->participants as $p): ?>
				<tr value="<?= Url::toRoute(['/participant/view','id'=>$p->id]) ?>" class="clickable" style="cursor:pointer">
					<td><?= $p->member->fullName ?></td>
					<td><?= $p->member->school ?></td>
					<td><?= $p->member->designation ?></td>
					<td><?= $p->role ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>