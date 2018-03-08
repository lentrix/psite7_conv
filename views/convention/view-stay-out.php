<?php 
use yii\helpers\Html;

$this->title = "View Stay Out Participants";
$this->params['breadcrumbs'][]=$this->title;
?>

<h1>Stay-out Participants</h1>
<div class="row">
	<div class="col-md-6">
		<div class="list-group">
			<?php foreach($participants as $p): ?>
				<?= Html::a($p->member->fullName, 
					['/participant/view','id'=>$p->id],
					['class'=>'list-group-item']
				) ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>