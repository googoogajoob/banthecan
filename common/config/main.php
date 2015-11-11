<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        // The TicketDecoration Manager Contains a list of all
        // available Ticket Decorations as well as their configurations.
        // Configurations in the DB for Board and Columns contain only the names
        // of the decorationClasses Array-Keys listed here
        // The details of the decoration class configurations are specified here
        'ticketDecorationManager' => [
            'class' => 'common\models\ticketDecoration\TicketDecorationManager',
            'availableTicketDecorations' => [
                'MoveToBacklog' => [
                    'class' => 'common\models\ticketDecoration\MoveToBacklog',
                    'linkIcon' => '<span class="glyphicon glyphicon-th"></span>',
                ],
                'MoveToKanban' => [
                    'class' => 'common\models\ticketDecoration\MoveToKanban',
                    'linkIcon' => '<span class="glyphicon glyphicon-object-align-top"></span>',
                ],
                'MoveToCompleted' => [
                    'class' => 'common\models\ticketDecoration\MoveToCompleted',
                    'linkIcon' => '<span class="glyphicon glyphicon-check"></span>',
                ],
                'ViewDetail' => [
                    'class' => 'common\models\ticketDecoration\ViewDetail',
                    'linkIcon' => '<span class="glyphicon glyphicon-eye-open"></span>',
                ],
            ],
        ],
    ],
];
