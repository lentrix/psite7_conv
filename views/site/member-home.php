<?php 
$this->title = "Member Home";

$member = Yii::$app->user->identity;

?>

<h1><?= $this->title ?></h1>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="large-text">Member Details</span>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-striped">
					<tr>
						<th>Participant</th><td><?= $member->fullName ?></td>
					</tr>
					<tr>
						<th>Email</th><td><?= $member->email ?></td>
					</tr>
					<tr>
						<th>Phone #</th><td><?= $member->phone ?></td>
					</tr>
					<tr>
						<th>School</th><td><?= $member->school ?></td>
					</tr>
					<tr>
						<th>Designation</th><td><?= $member->designation ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="large-text">Participation Details</span>
			</div>
			
			<div class="panel-body">

			<?php if($member->currentParticipation) : ?>

				<table class="table table-striped table-bordered">
					<tr>
						<th>Participation Role</th><td><?= $member->currentParticipation->role ?></td>
					</tr>
					<tr>
						<th>Room Assignment</th><td><?= $member->currentParticipation->room->name ?></td>
					</tr>
					<tr>
						<th>Room Mates</th>
						<td>
							<ul type="square">
							<?php foreach($member->currentParticipation->room->participants as $roomMate): ?>
								<?php if($roomMate->member->id !== $member->id) : ?>
									<li>
										<?= $roomMate->member->fullName ?><br>
										<i><?= $roomMate->member->school ?></i>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
							</ul>
						</td>
					</tr>
				</table>

				<?php else: ?>
					We are currently processing your registration.
				<?php endif; ?>
			</div>
			
		</div>
	</div>
</div>

<div class="alert alert-info">
	Note: If you see any discrepancies from your membership and participation information, please see
	the secretariat at your own convenient time to make necessary corrections.
</div>
