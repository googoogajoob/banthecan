<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;

/* @var $userBoards yii\data\ActiveDataProvider */
?>
<div class="row clearfix">
<p class="lead bg-primary col-xs-12 text-center">You are a member of more than one board.<br/> Select which board you want to use.</p>
</div>

<div class="row">
<?php
echo GridView::widget([
    'dataProvider' => $userBoards,
    'options' => [
        'class' => 'col-xs-12',
    ],
    'summary' => '',
    'columns' => [
        [
            'class'     => ActionColumn::className(),
            'template'  => '{select}',
            'buttons'   => [
                'select' => function($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', $url, [
                        'title' => 'Select',
                    ]);
                }
            ],
        ],
        [
            'attribute' => 'title',
            'format'    => 'ntext',
            'label'     => 'Title',
            'options'   => [
                'class' => 'col-xs-4',
            ],
        ],
        [
            'attribute' => 'description',
            'format'    => 'ntext',
            'label'     => 'Description'
        ],
    ],
]);
?>
</div>