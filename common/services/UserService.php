<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 17:06
 */

namespace common\services;


use common\essences\User;
use common\repositories\DatabaseUserRepository;
use Yii;

class UserService
{
//    private $userRepository;

    public function __construct()
    {
//        $this->userRepository = $userRepository;
    }

    public function getCurrentUser()
    {
        return Yii::$app->user->id;
    }

//    public function filterList()
//    {
//        return $this->userRepository->getListOfUsers();
//    }

//    public function findUserById($id) : User
//    {
//        return $this->userRepository->getUserById($id);
//    }

//    public function findAllUsers()
//    {
//        return $this->userRepository->getAllUsers();
//    }
}