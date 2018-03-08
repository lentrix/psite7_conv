<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Convention */

$this->title = 'Create Convention';
$this->params['breadcrumbs'][] = ['label' => 'Conventions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="convention-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
