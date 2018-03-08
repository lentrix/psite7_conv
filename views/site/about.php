<?php

use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Html;


$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me','class'=>'btn btn-primary'],
]);
?>

<?php Pjax::begin(); ?>
<?= Html::beginForm(['site/about'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::input('text', 'string', Yii::$app->request->post('string'), ['class' => 'form-control']) ?>
    <?= Html::submitButton('Hash String', ['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>

<h3><?= $stringHash ?></h3>
<?php Pjax::end(); ?>

<?php Modal::end() ?>