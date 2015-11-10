<?php

use frontend\assets\BacklogAsset;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $action string */


BacklogAsset::register($this);

$this->beginBlock('left-sidebar');

echo $this->render('@frontend/views/ticket/_backlogTicketSearchForm',[
        'searchModel' => $searchModel,
        'action' => $action,
    ]);

$this->endBlock();

$junk = $dataProvider->pagination->createUrl(0, -1) . '&pageSize=-1';

echo '<a href="' . $junk . '">Show all Tickets</a>';

echo ListView::widget( [
        'dataProvider' => $dataProvider,
        'itemView' => '@frontend/views/ticket/_ticketSingle',
        'viewParams' => [
            'divClass' => 'ticket-widget-float',
            'showTagMax' => 2,
        ],
        'itemOptions' => ['class' => 'col-xs-2'],
        'options' => ['class' => 'row'],
        'layout' => '{pager}{summary}{items}{pager}',
        'summaryOptions' => ['class' => 'summary apc-summary'],
        'pager' => [
            'firstPageLabel' => '|<',
            'lastPageLabel' => '>|',
            'options' => ['class' => 'pagination apc-pagination'],
            'maxButtonCount' => 10,
            'hideOnSinglePage' => true,
        ]
    ]
);