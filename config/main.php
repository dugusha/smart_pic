<?php
return [
    'id' => 'bass-web',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute'=>'default',
    'components' => [
        'request'=>[
            'parsers'=>[
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
//        'errorHandler' => [
//            'class'=>'app\components\ErrorHandler',
//            'errorAction' => 'default/error',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'language'=>'zh-CN',
    'sourceLanguage'=>'zh-CN',
];