<?php
use app\models\Election;

$this->title = "PSITE Election";
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title; ?></h1>

<?php if($model->status==Election::STATUS_PREP): ?>
	<div class="well">
		The election is in preparatory state.
	</div>
<?php endif; ?>