<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 12.07.18
 * Time: 11:34
 */
namespace common\repositories;

interface UserRepository
{
    public function createUser($username, $email, $password);

    public function getUserByUsername($username);

    public function getPasswordHashByUsername($username);

}