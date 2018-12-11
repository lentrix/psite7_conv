<?php 
use yii\helpers\Html;
use app\models\Election;

$this->title = "Election | Admin";

$this->params['breadcrumbs'][] = $this->title;
?>

<!-- No election data yet. -->

<div class="alert alert-warning">
	<div class="pull-right">
		<?= Html::a('Create Election',['/election/create'],['class'=>'btn btn-primary']) ?>
	</div>
	<span class="large-text">No Election is created yet.</span>
	<p>Please create an election</p>
</div>
