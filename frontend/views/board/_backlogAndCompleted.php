<?php

use frontend\assets\BacklogAsset;
use yii\widgets\ListView;
use yii\data\Sort;

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

echo 'Hey Dude';

echo ListView::widget( [
        'dataProvider' => $dataProvider,
        'itemView' => '@frontend/views/ticket/_ticketSingle',
        'viewParams' => [
            'divClass' => 'ticket-widget-float',
            'showTagMax' => 2,
        ],
        'itemOptions' => ['class' => 'col-xs-6 col-sm-4 col-md-3 col-lg-2'],
        'options' => ['class' => 'row'],
        'layout' => '{pager}{summary}{sorter}{items}{pager}',
        'summaryOptions' => ['class' => 'summary apc-summary'],
        'pager' => [
            'firstPageLabel' => '<span class="glyphicon glyphicon-step-backward"></span>',
            'lastPageLabel' => '<span class="glyphicon glyphicon-step-forward"></span>',
            'prevPageLabel' => '<span class="glyphicon glyphicon-chevron-left"></span>',
            'nextPageLabel' => '<span class="glyphicon glyphicon-chevron-right"></span>',
            'options' => ['class' => 'pagination apc-pagination'],
            'maxButtonCount' => 10,
            'hideOnSinglePage' => true,
        ],
        'sorter' => [
            'options' => [
                'class' => 'ticket-sorter'
            ]
        ],
    ]
);