<?php 
$convention = \app\models\Convention::getActive();
$election = $convention->election;
$starter = \app\models\Member::findOne($election->started_by);
$nVoters = \app\models\Participant::find()->where(['convention_id'=>$convention->id])->count();
$voted = \app\models\Participant::find()->where(['convention_id'=>$convention->id, 'has_voted'=>1])->count();
$pct = ($voted/$nVoters)*100;
?>

<h3>Election Status</h3>
<table class="table table-striped table-bordered">
	<tr>
		<th>Started on</th>
		<td><?= date('F d, Y', strtotime($election->start)) ?></td>
	</tr>
	<tr>
		<th>Started by</th>
		<td><?= $starter->fullName ?></td>
	</tr>
	<tr>
		<th>Potential Voters</th>
		<td><?= $nVoters ?></td>
	</tr>
	<tr>
		<th>Actually Voted</th>
		<td><?= $voted ?></td>
	</tr>
	<tr>
		<th>Percentage Complete</th>
		<td><?= $pct ?>%</td>
	</tr>
</table>