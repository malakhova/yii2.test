<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 12.07.18
 * Time: 11:34
 */
namespace common\repositories;

use common\essences\User;

interface UserRepository
{
    public function createUser($username, $email, $password);

    public function getUserById($id) : User;

    public function getUserByUsername($username)  : User;

    public function getPasswordHashByUsername($username);

    public function getListOfUsers();

    public function getAllUsers();

}