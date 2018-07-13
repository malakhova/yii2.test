<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 09.07.18
 * Time: 16:54
 */

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'login' => 'site/login',
        '' => 'site/index',
        '<_a:(about|contact)>' => 'site/<_a>',
        'categories' => 'category',
        '<controller:[\w-]+>s' => '<controller>',
        '<controller:[\w-]+>/<_a:(view|update)>/<id:\d+>' => '<controller>/<_a>',

//
//        'PUT <controller:[\w-]+>/update/<id:\d+>'    => '<controller>/update',
//        'DELETE <controller:[\w-]+>/<id:\d+>' => '<controller>/delete',
//        '<controller:[\w-]+>/<id:\d+>'        => '<controller>/view'
//        'about' => 'site/about',
//        'contact' => 'site/contact',
//        '<category:[\w_-]+>/view' => '<category:[\w_-]+>/<id:[\d]+>',
//        '<category:[\w_-]+>' => '/category',
    ]
];