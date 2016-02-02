<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 11/22/15
 * Time: 2:58 PM
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;

echo Html::a(
\Yii::t('app', 'Completed'),
    '/board/completed', [
        'class' => 'btn btn-primary apc-header-button pull-right',
        'id' => 'header-completed-button',
]
);

echo Html::a(
    'Kanban',
    '/board', [
        'class' => 'btn btn-primary apc-header-button pull-right',
        'id' => 'header-kanban-button',
]
);

echo Html::a(
\Yii::t('app','Backlog'),
    '/board/backlog', [
        'class' => 'btn btn-primary apc-header-button pull-right',
        'id' => 'header-backlog-button',
]
);

echo Html::button(
\Yii::t('app','Create Ticket'), [
        'value' => '/ticket/new',
        'class' => 'btn btn-success apc-header-button pull-right',
        'id' => 'header-create-button',
    ]);

Modal::begin([
    'header' => '<h2>' . \Yii::t('app','Create Ticket') . '</h2>',
    'id' => 'create-ticket-modal',
    'size' => 'modal-lg',
]);
echo '<div id="create-ticket-modal-content"></div>';
Modal::end();