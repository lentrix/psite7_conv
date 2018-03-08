<?php 
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = "Members";
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function(){    
    $(".clickable").click(function(){
        document.location = $(this).attr('value');
    });
});
JS;

$this->registerJS($script);

// Modal::begin([
//     'header'=>'<h3>Update User</h3>',
//     'id' => 'modal'
// ]);

// echo "<div id='modalContent'></div>";

// Modal::end();
?>

<?php Modal::begin([
    'header'=>'<h3>Add User</h3>',
    'id' => 'modal-add',
    'toggleButton' => [
        'label'=>'<i class="glyphicon glyphicon-plus"></i> Add Member',
        'class'=>'btn btn-primary pull-right'
    ],
]); ?>
    <?= $this->render('/member/create.php',['member'=>new \app\models\Member,'page'=>'/member/index']); ?>
<?php Modal::end(); ?>

<h1><?=$this->title?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [       
        'email',
        'lname',
        'fname',
        'school',
        'designation',
        [
            'attribute'=>'active',
            'content' => function($model, $key, $index, $column) {
                return "<i class='glyphicon glyphicon-" . ($model->active?"check":"remove") . "'></i>";
            }
        ]
    ],
    'rowOptions' => function($model, $key, $index, $grid) {
        return [
            'style' => 'cursor: pointer',
            'value' => Url::toRoute(['/member/view','id'=>$model->id]),
            'class' => 'clickable',
        ];
    },
    'tableOptions' => [
        'class'=>'table table-striped table-bordered table-hover'
    ],
]); ?>
