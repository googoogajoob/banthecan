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
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],

        'session' => [
            'class' => 'yii\web\DbSession',
            // Set the following if you want to use DB component other than
            // default 'db'.
            // 'db' => 'mydb',
            // To override default session table, set the following
            // 'sessionTable' => 'my_session',
        ],

        'view' => [
            'on endPage' => function ($event) {
                echo $event->sender->renderFile('@frontend/views/layouts/partials/_javascriptConsole.php');
            },
        ],
    ],
];
