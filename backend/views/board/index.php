<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Boards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Board', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
/*            [
                'label' => 'Ticket Backlog Configuration',
                'attribute' => 'ticket_backlog_configuration',
            ],*/
/*            [
                'label' => 'Ticket Completed Configuration',
                'value' => implode(', ', $dataProvider->ticket_completed_configuration),
            ],*/
            'entry_column',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
