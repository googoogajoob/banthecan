<?php

use yii\grid\GridView;

/* @var $userBoards yii\data\ActiveDataProvider */
?>

<p class="lead bg-primary">You are a member of more than one board. Select which board you want to use.</p>

<?php
echo GridView::widget([
    'dataProvider' => $userBoards,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

        'title:ntext',
        'description:ntext',

        //['class' => 'yii\grid\ActionColumn'],
    ],
]);

?>
