<?php

use frontend\assets\BacklogAsset;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

BacklogAsset::register($this);

echo $this->render('@frontend/views/ticket/_ticketSearchFilter',[
        'searchModel' => $searchModel,
    ]);

echo ListView::widget( [
        'dataProvider' => $dataProvider,
        'itemView' => '@frontend/views/ticket/_ticketBlock',
        'viewParams' => ['divClass' => 'ticket-widget-float'],
        'itemOptions' => ['class' => 'col-xs-2'],
        'options' => ['class' => 'row'],
        'pager' => [
            'firstPageLabel' => '|<',
            'lastPageLabel' => '>|',
        ]
    ]
);