<?php
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;

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

	<span class="pull-right">
		<?php if(!$model->isParticipant): ?>
			<?php Modal::begin([
			    'header'=>'<h3>Add as Participant</h3>',
			    'id' => 'modal-add',
			    'toggleButton' => [
			        'label'=>'<i class="glyphicon glyphicon-plus"></i> Add as Participant',
			        'class'=>'btn btn-success'
			    ],
			]); ?>
			    <?= $this->render('/participant/add',['model'=>$participant]); ?>
			<?php Modal::end(); ?>
		<?php endif; ?>

		<?php if($user->role===1): ?>
			<?= Html::a(($model->active?'Deactivate ':'Activate ') . 'Member', 
				['/member/toggle-active','id'=>$model->id],
				[
					'class'=>'btn btn-' . ($model->active?'warning':'success'),
					'data' => [
						'confirm' => 'Are you sure you want to disable this member?'
					],
				]
			);?>
		<?php endif; ?>

		<?php if($user->role==1 || $user->id==$model->id): ?>
			<?php Modal::begin([
			    'header'=>'<h3>Update User</h3>',
			    'id' => 'modal-update',
			    'toggleButton' => [
			        'label'=>'<i class="glyphicon glyphicon-edit"></i> Update Member',
			        'class'=>'btn btn-primary'
			    ],
			]); ?>
			    <?= $this->render('/member/update',['model'=>$model,'page'=>'/member/index']); ?>
			<?php Modal::end(); ?>
		<?php endif; ?>
	</span>	
</div>
<?php 

$this->title = "Member Details";
$this->params['breadcrumbs']= [];
$this->params['breadcrumbs'][] = ['label'=>'Members','url'=>['/member/index']];
$this->params['breadcrumbs'][] = $model->fullName;

?>
<div class="row">
	<div class="col-md-5">
		<h1><?= $this->title; ?></h1>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'id',
				'email',
				'lname',
				'fname',
				'nickname',
				'school',
				'designation',
				'statusText'
			]
		]); ?>

	</div>
	<div class="col-md-7">
		<h2>Participation History</h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Date</th>
					<th>Venue</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model->participants as $p): ?>
				<tr class="clickable" style="cursor:pointer" value="<?= Url::toRoute(['/participant/view','id'=>$p->id]) ?>">
					<td><?= date('F d, Y', strtotime($p->convention->date_start));?></td>
					<td><?= $p->convention->venue ?></td>
					<td><?= $p->role ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>