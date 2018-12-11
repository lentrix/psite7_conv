<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;


$this->title = "Raffle Draw";

$this->params['breadcrumbs'][] = $this->title;

?>

<?php if(Yii::$app->user->identity->role==1) : ?>
<div class="pull-right">
	
	<? Modal::begin([
		    'header'=>'<h3 id="modal-header"></h3>',
		    'id' => 'modal1',
		    'size' =>'modal-md',
		    'header' => 'Pre-Draw',
		    'headerOptions' => ['class'=>'large-text'],
		    'toggleButton' => [
		    	'label' => '<i class="glyphicon glyphicon-star"></i> Draw Raffle Item',
		    	'class' => ['btn btn-success']
		    ]
		]); ?>
		
		<?= $this->render('_predraw_form', compact('drawables')) ?>

	<?php Modal::end() ?>
	<? Modal::begin([
		    'header'=>'<h3 id="modal-header"></h3>',
		    'id' => 'modal2',
		    'size' =>'modal-md',
		    'header' => 'Add Raffle Item',
		    'headerOptions' => ['class'=>'large-text'],
		    'toggleButton' => [
		    	'label' => '<i class="glyphicon glyphicon-piggy-bank"></i> Add Raffle Item',
		    	'class' => ['btn btn-primary']
		    ]
		]); ?>

		<?php $raffle = new \app\models\Raffle; ?>
		<div>
			<?php $form = ActiveForm::begin(['action'=>Url::toRoute(['/raffle/add'])]) ?>

				<?= $form->field($raffle, 'prize')->textInput() ?>
				<div class="form-group">
					<?= Html::submitButton('Add Raffle Item', ['class'=>'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>
		</div>

	<?php Modal::end(); ?>
	
</div>

<?php endif; ?>


<h1><?= $this->title ?></h1>


<h3>Raffle Items</h3>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [       
        'prize',
        //['label'=>'Added on', 'value'=>date('F d, Y g:i:s', strtotime($row->created))],
        ['label'=>'Added on', 'attribute'=>'created','format'=>['datetime', 'php:F d, Y g:i:s a']],
        ['label'=>'Created by', 'value' => 'createdBy.fullName'],
        ['label' => 'Winner', 'value' => 'participant.member.fullName'],
        ['label' => 'Drawn on', 'attribute'=>'drawn', 'format'=>['datetime', 'php:F d, Y g:i:s a']],
        [
        	'label' => 'Action', 
        	'format'=>'raw',
        	'value'=> function($model) {
        		if(Yii::$app->user->identity->role==1) {
	        		return "<center>" . Html::a('<i class="glyphicon glyphicon-duplicate"></i>', [
	        			'/raffle/duplicate', 'id'=>$model->id
	        		], ['class'=>'btn btn-xs btn-primary', 'title'=>'Duplicate prize']) . "</center>";
        		}else {
        			return '<center><i class="glyphicon glyphicon-ban-circle"></i></center>';
        		}
        	},
        ]
    ],
    'tableOptions' => [
        'class'=>'table table-striped table-bordered table-hover'
    ],
    
]); ?>