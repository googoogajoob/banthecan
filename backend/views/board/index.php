<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'Boards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('app', 'Create Board'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
            'title:ntext',
            [
                'attribute' => 'description',
                'format' => 'ntext',
            ],
            'max_lanes',
            'backlog_name',
            'kanban_name',
            'completed_name',
            [
                'label' => \Yii::t('app', 'Ticket Backlog Configuration'),
                'attribute' => 'ticket_backlog_configuration',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return implode(', ', $model->ticket_backlog_configuration);
                },
            ],
            [
                'label' => \Yii::t('app', 'Ticket Completed Configuration'),
                'attribute' => 'ticket_completed_configuration',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return implode(', ', $model->ticket_completed_configuration);
                },
            ],
            'entry_column',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
