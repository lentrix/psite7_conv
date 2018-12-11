<?php 

$this->title = "Election | Result";
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>
<div class="row">
	<div class="col-md-6">
		<div class="well">
			<div class="list-group">
				<?php $counter = 0; ?>
				<?php foreach($results as $name=>$votes): ?>
					<?php $counter++ ?>
					<span class="list-group-item">
						<?= $counter<=$no_of_winners?'<i class="glyphicon glyphicon-star"></i>':'' ?> <?= $name ?>
						<span class="badge pull-right">
							<?= $votes ?>
						</span>
					</span>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

</div>
	