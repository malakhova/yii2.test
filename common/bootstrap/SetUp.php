<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 11.07.18
 * Time: 18:31
 */

namespace common\bootstrap;

use Yii;
use yii\base\BootstrapInterface;
use  \yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app){
        $container = Yii::$container;
        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });
    }

}