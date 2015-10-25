<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\JuiAsset;
use backend\assets\ColumnAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

ColumnAsset::register($this);
$this->title = 'Board Columns';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="board-column-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Create Board Column', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['id' => 'sort', 'class' => 'table table-striped table-bordered'],
        'rowOptions' => function($model, $key, $index, $grid) {
            return ['id' => 'row_' . $key, 'display-order' => $model->display_order];
        },
        'columns' => [
            'id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'board_id',
            'title:ntext',
            'display_order',
            'receiver',
            'updated_at:datetime:Updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);

    ?>

</div>
