<?php 
use yii\helpers\Html;

$this->title = "Election | Device Not Authorized.";


?>

<h1><?= $this->title ?></h1>
<div class="pull-right">
	<?php if(Yii::$app->user->identity->role==1): ?>

		<?= Html::a('<i class="glyphicon glyphicon-lock"></i> Authorize This Device', 
			['/election/device-authorize'],
			[
				'class'=>'btn btn-lg btn-primary',
				'data' => [
					'method' => 'POST'
				]
			]
		) ?>

	<?php endif; ?>
</div>

<div class="row">
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
</div>