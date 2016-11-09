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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
//'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
//'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

        'view' => [
            'on endPage' => function ($event) {
                echo $event->sender->renderFile('@frontend/views/layouts/partials/_javascriptConsole.php');
            },
        ],

/* The TicketDecoration Manager Contains a list of all
 * available Ticket Decorations as well as their configurations.
 * Configurations for Board and Columns are persistent but they contain
 * only the names of the decorationClasses and the array-keys listed here
 * The relation to columns and boards are configured in the Back-End.
 *
 * The details of the decoration class configurations are specified here
 *
 * In short:
 *  1) here the decorations show up is configured in the Back End
 *  2) what the decorations do is configured here
 */
        'ticketDecorationManager' => [
            'class' => 'common\models\ticketDecoration\TicketDecorationManager',
            'availableTicketDecorations' => [
                'CreateResolution' => [
                    'class' => 'common\models\ticketDecoration\CreateResolution',
                    'linkIcon' => '<span class="glyphicon glyphicon-list-alt"></span>',
                    'displaySection' => 2,
                ],
                'CreateTask' => [
                    'class' => 'common\models\ticketDecoration\CreateTask',
                    'linkIcon' => '<span class="glyphicon glyphicon-wrench"></span>',
                    'displaySection' => 2,
                ],
                'CopyTicket' => [
                    'class' => 'common\models\ticketDecoration\CopyTicket',
                    'linkIcon' => '<span class="glyphicon glyphicon-duplicate"></span>',
                ],
                'MoveToBacklog' => [
                    'class' => 'common\models\ticketDecoration\MoveToBacklog',
                    'linkIcon' => '<span class="glyphicon glyphicon-th"></span>',
                    'movement' => true,
                ],
                'MoveToCompleted' => [
                    'class' => 'common\models\ticketDecoration\MoveToCompleted',
                    'linkIcon' => '<span class="glyphicon glyphicon-check"></span>',
                    'movement' => true,
                ],
                'MoveToKanban' => [
                    'class' => 'common\models\ticketDecoration\MoveToKanban',
                    'linkIcon' => '<span class="glyphicon glyphicon-object-align-top"></span>',
                    'movement' => true,
                ],
                'ProtocolStatus' => [
                    'class' => 'common\models\ticketDecoration\ProtocolStatus',
                    'linkIcon' => '<span class="glyphicon glyphicon-pencil"></span>',
                    'displaySection' => 2,
                ],
                'ViewDetail' => [
                    'class' => 'common\models\ticketDecoration\ViewDetail',
                    'linkIcon' => '<span class="glyphicon glyphicon-eye-open"></span>',
                ],
                'Vote' => [
                    'class' => 'common\models\ticketDecoration\Vote',
                    'plusLinkIcon' => '<span class="glyphicon glyphicon-plus"></span>',
                    'minusLinkIcon' => '<span class="glyphicon glyphicon-minus"></span>',
                    'decorationKey' => 'backlogPriority',
                    'voteAttribute' => 'vote_priority',
                ],
            ],
        ],
    ],
];
