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
    'Completed',
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
    'Backlog',
    '/board/backlog', [
        'class' => 'btn btn-primary apc-header-button pull-right',
        'id' => 'header-backlog-button',
    ]
);

echo Html::a(
    'Create Ticket',
    '#', [
        'class' => 'btn btn-success apc-header-button pull-right',
        'id' => 'header-create-button',
    ]
);

Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me'],
]);

echo 'Say hello...';

Modal::end();