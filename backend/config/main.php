<?php
use yii\filters\AccessControl;
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\essences\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true,
                'domain' => '.test-project.test'
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced',
            'cookieParams' => [
                'domain' => '.test-project.test',
                'httpOnly' => true
            ]
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
        'frontendUrlManager' => require __DIR__ .'/../../frontend/config/urlManager.php',
        'backendUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function (){
            return Yii::$app->get('frontendUrlManager');
        }
//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'rules' => [
//            ]
//        ]
    ],
    'as access' => [
        'class' => AccessControl::className(),
        'except' =>[
            'site/login',
            'site/error',
            'site/index',],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
