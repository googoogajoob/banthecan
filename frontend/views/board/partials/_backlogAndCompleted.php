<?php

use frontend\assets\BacklogAsset;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $action string */
/* @var $currentPageSize integer */
/* @var $showPriority boolean */

BacklogAsset::register($this);

$this->beginBlock('left-sidebar');

echo $this->render('@frontend/views/ticket/partials/_backlogTicketSearchForm', [
    'searchModel' => $searchModel,
    'currentPageSize' => $currentPageSize,
    'action' => $action,
    'showPriority' => $showPriority,
]);

$this->endBlock();

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@frontend/views/ticket/partials/_ticketSingle',
    'viewParams' => [
        'divClass' => 'ticket-widget-float',
        'showTags' => true,
        'showPriority' => $showPriority,
    ],
    'itemOptions' => [
        'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-2',
    ],
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
]);