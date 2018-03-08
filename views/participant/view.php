<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Participant */

$this->title = "View Participant";
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                <tr><th>Participation ID</th><td><?= $model->id ?></td></tr>
                <tr>
                    <th>Participant</th>
                    <td>
                        <?= $model->member->fullName?>
                        <?= Html::a('<i class="glyphicon glyphicon-open"></i>',
                            ['/member/view','id'=>$model->member_id],
                            ['class'=>'btn btn-success btn-xs pull-right','title'=>'View Member Detail']
                        );?>
                    </td>
                            
                </tr>
                <tr><th>School</th><td><?= $model->member->school?></td></tr>
                <tr>
                    <th>Room</th>
                    <td>
                        <?php if($model->room): ?>
                            <?= $model->room->name?>
                            <?= Html::a('<i class="glyphicon glyphicon-open"></i>',
                                ['/convention/view-room','id'=>$model->room_id],
                                ['class'=>'btn btn-success btn-xs pull-right','title'=>'View Room']
                            );?>
                        <?php else: ?>
                            Stay Out
                            <?= Html::a('<i class="glyphicon glyphicon-open"></i>',
                                ['/convention/view-stay-out'],
                                ['class'=>'btn btn-success btn-xs pull-right','title'=>'View Stay Out']
                            );?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr><th>Role</th><td><?= $model->role?></td></tr>
            </table>
        </div>
    </div>
</div>
