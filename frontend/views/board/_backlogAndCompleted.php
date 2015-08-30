<?php

use frontend\assets\BacklogAsset;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $action string */


BacklogAsset::register($this);

echo $this->render('@frontend/views/ticket/_backlogTicketSearchForm',[
        'searchModel' => $searchModel,
        'action' => $action,
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
            'options' => [
                'class' => 'pagination apc-pagination',
            ],
        ]
    ]
);