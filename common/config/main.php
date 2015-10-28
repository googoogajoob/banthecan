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
                /*'Generic' => [
                    'class' => 'common\models\ticketDecoration\Generic',
                    'linkIcon' => 'G',
                ],*/
                'MoveToBacklog' => [
                    'class' => 'common\models\ticketDecoration\MoveToBacklog',
                    'linkIcon' => 'B',
                ],
                'MoveToKanban' => [
                    'class' => 'common\models\ticketDecoration\MoveToKanban',
                    'linkIcon' => 'K',
                ],
                'MoveToCompleted' => [
                    'class' => 'common\models\ticketDecoration\MoveToCompleted',
                    'linkIcon' => 'C',
                ],
            ],
        ],
    ],
];
