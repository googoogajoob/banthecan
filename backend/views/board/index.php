<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'Boards');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="board-index">

<h1><?php echo Html::encode($this->title) ?></h1>

<p><?php echo Html::a(\Yii::t('app', 'Create Board'), ['create'], ['class' => 'btn btn-success']) ?></p>

<?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            'created_at:datetime',
            'updated_at:datetime',
            'title:ntext',
            [
                'attribute' => 'description',
                'format' => 'ntext',
            ],
            'backlog_name',
            'kanban_name',
            'completed_name',
            'entryColumnName',
        ],
    ]);
?>

</div>
