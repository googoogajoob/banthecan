<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\assets\ColumnAsset;
use common\models\Column;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ColumnSearch */
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
        'filterModel' => $searchModel,
        'tableOptions' => ['id' => 'sort', 'class' => 'table table-striped table-bordered'],
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => 'row_' . $key, 'display-order' => $model->display_order];
        },
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            'created_at:datetime',
            'updated_at:datetime',
            'board_id',
            'boardTitle',
            'title:ntext',
            'receiverList:ntext:Receiver',
            [
                'label' => \Yii::t('app', 'Decorations'),
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    if (is_array($model->ticket_column_configuration)) {
                        return implode(', ', $model->ticket_column_configuration);
                    } else {
                        return '';
                    }

                },
            ],
        ],
    ]);

    ?>
</div>
