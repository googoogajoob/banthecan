<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\JuiAsset;
use backend\assets\ColumnAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

ColumnAsset::register($this);
$this->title = \Yii::t('app', 'Board Columns');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="board-column-index">

<h1><?php echo Html::encode($this->title) ?></h1>

<p><?php echo Html::a(\Yii::t('app', 'Create Board Column'), ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['id' => 'sort', 'class' => 'table table-striped table-bordered'],
        'rowOptions' => function($model, $key, $index, $grid) {
return ['id' => 'row_' . $key, 'display-order' => $model->display_order];
        },
        'columns' => [
            'id',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
            'board_id',
            'title:ntext',
            'display_order',
            'receiver',
        [
                'label' => \Yii::t('app', 'Ticket Column Configuration'),
                'attribute' => 'ticket_column_configuration',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
        return implode(', ', $model->ticket_column_configuration);
                },
                ],


                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]);

                ?></div>
