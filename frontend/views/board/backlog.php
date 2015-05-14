<?php

use frontend\assets\BacklogAsset;
use yii\widgets\ListView;

/* @var $tickets common\models\Ticket */

BacklogAsset::register($this);

$this->params['breadcrumbs'][] = 'Backlog';

echo $this->render('@frontend/views/ticket/_ticketSearchFilter');

echo ListView::widget( [
        'dataProvider' => $dataProvider,
        'itemView' => '@frontend/views/ticket/_ticketBlock',
        'viewParams' => ['divWrapper' => true, 'divClass' => 'ticket-widget-float'],
        'itemOptions' => ['class' => 'col-xs-2'],
        'options' => ['class' => 'row'],
        'pager' => [
            'firstPageLabel' => '|<',
            'lastPageLabel' => '>|',
        ]
    ]
);