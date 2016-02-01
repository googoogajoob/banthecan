<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;

/* @var $userBoards yii\data\ActiveDataProvider */
?>
<div class="row clearfix">
<p class="lead bg-primary col-xs-12 text-center"><?php
echo \Yii::t('app',
        'You are a member of more than one board.<br/> Select which board you want to use.');
?></p>
</div>

<div class="row"><?php
echo GridView::widget([
    'dataProvider' => $userBoards,
    'options' => [
        'class' => 'col-xs-12',
],
    'summary' => '',
    'columns' => [
[
            'class'     => ActionColumn::className(),
            'template'  => '{activate}',
            'buttons'   => [
                'activate' => function($url, $model, $key) {
return Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', $url, [
                        'title' => 'Set Active Board',
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
            ?></div>
