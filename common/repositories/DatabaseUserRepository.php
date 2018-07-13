<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 12.07.18
 * Time: 11:35
 */
namespace common\repositories;

use common\essences\User;
use Error;

class DatabaseUserRepository implements UserRepository
{

    public function createUser($username, $email, $password){
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
    public function getUserByUsername($username) : User
    {
        // TODO: Implement getByUsername() method.
        $user = User::findOne(['username' => $username, 'status' => User::STATUS_ACTIVE]);
        if ($user) {
            return $user;
        } else throw new Error("User not found in Database");
    }

    public function getPasswordHashByUsername($username)
    {
        // TODO: Implement getPasswordHashByUsername() method.
        $user = User::findOne(['username' => $username, 'status' => User::STATUS_ACTIVE]);
        return $user->password_hash;
    }
}