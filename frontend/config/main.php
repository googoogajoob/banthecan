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
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            //for other options see http://stackoverflow.com/questions/27316780/how-to-config-yii2-urlmanager-rules-with-aliases-and-get-parameter
            'rules' => [
                //''                                          => '/',
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
    ],
    'params' => $params,
];
