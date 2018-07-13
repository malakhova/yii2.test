<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'login' => 'site/login',
        '' => 'site/index',
        '<_a:(about|contact)>' => 'site/<_a>',
        '<controller:[\w-]+>s' => '<controller>',
        '<controller:[\w-]+>/<_a:(view|update)>/<id:\d+>' => '<controller>/<_a>',
    ]
];