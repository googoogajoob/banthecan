<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Board */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Boards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'title:ntext',
            'description:ntext',
            'max_lanes',
            'backlog_name',
            'kanban_name',
            'completed_name',
            [
                'label' => \Yii::t('app', 'Ticket Backlog Configuration'),
                'value' => implode(', ', $model->ticket_backlog_configuration),
            ],
            [
                'label' => \Yii::t('app', 'Ticket Completed Configuration'),
                'value' => implode(', ', $model->ticket_completed_configuration),
            ],
            'entry_column',
         ],
    ]) ?>

</div>
