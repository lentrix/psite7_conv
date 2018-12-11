<?php 
use yii\helpers\Html;
use app\models\Election;

$this->title = "Election | Done Voting";
$this->params['breadcrumbs'][] = $this->title;

?>

<?php if(Yii::$app->user->identity->role==1): ?>

	<?= Html::a('Close Election <i class="glyphicon glyphicon-remove"></i>', 
		['/election/change-status','value'=>Election::STATUS_CLOSED],
		[
			'class'=>'btn btn-warning pull-right',
			'data' => [
				'confirm' => 'Are you sure you want to close the election now?',
				'method' => ['post'],
			],
		]
	) ?>

<?php endif; ?>

<h1><?= $this->title ?></h1>

<div class="alert alert-success">
	Thank you very much for actively participating in our PSITE-7 Election.
	Please visit this page later when the election is closed to view the 
	results.
</div>

<?php if(Yii::$app->user->identity->role==1): ?>
<hr>
<div class="col-md-6">
	<?= $this->render('_status') ?>	
</div>
<?php endif; ?>


		