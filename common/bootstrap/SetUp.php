<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 11.07.18
 * Time: 18:31
 */

namespace common\bootstrap;

use common\repositories\CommentRepository;
use common\repositories\DatabaseCommentRepository;
use common\repositories\DatabasePostRepository;
use common\repositories\DatabaseUserRepository;
use common\repositories\PostRepository;
use common\repositories\UserRepository;
use common\services\CommentService;
use common\services\PostService;
use common\services\UserService;
use Yii;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(CommentRepository::class, DatabaseCommentRepository::class);
        $container->setSingleton(PostRepository::class, DatabasePostRepository::class);
        $container->setSingleton(UserRepository::class, DatabaseUserRepository::class);

        $container->setSingleton('CommentService', CommentService::class);
        $container->setSingleton('PostService', PostService::class);
        $container->setSingleton('UserService', UserService::class);

    }

}