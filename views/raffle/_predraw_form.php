
<?php 
use yii\widgets\ActiveForm; 
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>

<?php $preDraw = new \app\models\PredrawForm; ?>
<div>
	<?php $pForm = ActiveForm::begin(['action'=>Url::toRoute(['/raffle/draw'])]) ?>

	<?= $pForm->field($preDraw, 'raffle_id')->dropDownList(
		ArrayHelper::map($drawables, 'id', 'prize'),
		['class'=>'form-control']
	); ?>

	<?= $pForm->field($preDraw, 'exclusive')->checkBox(); ?>

	<div class="form-group">
		<?= Html::submitButton('Proceed', ['class'=>'btn btn-primary']); ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>
