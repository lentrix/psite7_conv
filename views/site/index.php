<?php 
use yii\helpers\Html;

$this->title = Yii::$app->name . " | Home";

?>

<div>
	 <?= Html::img('/images/psite_7_2018_banner.jpg',['width'=>'100%','style'=>'float:right']) ?>
    <!-- <img src="./images/psite_7_2018_banner.jpg" width="100%" style="float:right"> -->
    <?php if(Yii::$app->user->isGuest) : ?>
    <?= Html::a('Register', ['/site/register'],['class'=>'btn btn-success btn-lg welcome-button hidden-sm hidden-xs']); ?>
    <?php endif; ?>
</div>
