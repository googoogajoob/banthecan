<?php

use yii\grid\GridView;

/* @var $userBoards \common\models\Board */

echo GridView::widget([
    'dataProvider' => $userBoards,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'title:ntext',
        'description:ntext',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]);

?>
