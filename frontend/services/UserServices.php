<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 12.07.18
 * Time: 14:48
 */

namespace frontend\services;


use frontend\repositories\DatabaseUserRepository;
use Yii;

/**
 * @property DatabaseUserRepository $userRepository
 */
class UserServices
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new DatabaseUserRepository();
    }

    public function validatePassword($username, $password)
    {
        $passwordHash = $this->userRepository->getPasswordHashByUsername($username);
        return Yii::$app->security->validatePassword($password, $passwordHash);
    }
}