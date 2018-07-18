<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 17:06
 */

namespace common\services;


use Yii;

class UserService
{
    public function getCurrentUser()
    {
        return Yii::$app->user->id;
    }
}