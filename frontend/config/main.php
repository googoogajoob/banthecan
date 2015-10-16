<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'params' => $params,
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            //for other options see http://stackoverflow.com/questions/27316780/how-to-config-yii2-urlmanager-rules-with-aliases-and-get-parameter
            'rules' => [
                '/'                                         => '/',
                'site'                                      => '/',
                'site/index'                                => '/',
                'site/<action:\w+>'                         => 'site/<action>',
                '<controller:\w+>'                          => '<controller>',
                '<controller:\w+>/<id:\d+>'                 => '<controller>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'    => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'             => '<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //'formatter' => [
        //    'locale' => 'de-DE',
        //],

        // The TicketDecoration Manager Contains a list of all available Ticket Decorations
        // as well as their configurations.
        // Configurations in the DB for Board and Columns contain only the names
        // of the decorationClasses Array-Keys listed here
        // The details of the decoration class configurations are specified here
        'ticketDecorationManager' => [
            'class' => 'common\models\ticketDecoration\TicketDecorationManager',
            'decorationClasses' => [
                'Dummy' => [
                    'class' => 'common\models\ticketDecoration\Dummy',
                ],
                'Generic' => [
                    'class' => 'common\models\ticketDecoration\Generic',
                ],
                'Smart' => [
                    'class' => 'common\models\ticketDecoration\Smart',
                ],
                'MoveToBoard' => [
                    'class' => 'common\models\ticketDecoration\MoveToBoard',
                ],
            ],
        ],
    ],
];
