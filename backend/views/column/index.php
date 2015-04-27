<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\JuiAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Board Columns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-column-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Board Column', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['id' => 'sort', 'class' => 'table table-striped table-bordered'],
        'rowOptions' => function($model, $key, $index, $grid) {
            return ['id' => 'row_' . $key, 'display-order' => $model->display_order];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'updated_at',
            'board_id',
            'title:ntext',
            'display_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);

    JuiAsset::register($this);

    $this->registerJs(
        'var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };'
    );
    $this->registerJs('jQuery("#sort > tbody").sortable({helper: fixHelper}).disableSelection();');

    $this->registerJs(
        'jQuery("#sort > tbody").on("sortupdate", function (event, ui) {
            columnOrder(event, ui, this);
        });'
    );

    ?>

</div>
