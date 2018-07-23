<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 12.07.18
 * Time: 10:40
 */

namespace common\services;


use common\forms\LoginForm;
use common\repositories\DatabaseUserRepository;
use Exception;
use frontend\forms\SignupForm;
use Yii;

/**
 * @property DatabaseUserRepository $userRepository
 */
class AuthorizationService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new DatabaseUserRepository();
    }

    public function isUserAuthorized(): bool
    {
        return !Yii::$app->user->isGuest;
    }

//    public function userIsLogin(LoginForm $form)
//    {
//        if ($form->validate()) {
//            return Yii::$app->user->login($this->userRepository->getUserByUsername($form->username), $form->rememberMe ? 3600 * 24 * 30 : 0);
//        }
//        return false;
////        throw new Error("Form is not validate");
//    }
//
//
//    public function loginIsOK(LoginForm $form)
//    {
//        if ($form->load(Yii::$app->request->post()) && $this->userIsLogin($form))
//        {
//            $isLogin = true;
//        }
//        else {
//            $form->password = '';
//            $isLogin = false;
//        }
////
//        return $isLogin;
//    }

    public function login(LoginForm $form)
    {
        $user = $this->userRepository->getUserByUsername($form->username);
        if (!$user->validatePassword($form->password)) {
            throw new Exception("Password validate if failed");
        }
        Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);

    }

    public function logout()
    {
        Yii::$app->user->logout();
    }

    public function signup(SignupForm $form)
    {
        $username = $form->username;
        $email = $form->email;
        $password = $form->password;

        $user = $this->userRepository->createUser($username, $email, $password);
        if (!Yii::$app->getUser()->login($user)) {
            throw new Exception();
        }

//        if ($user) {
//            if (Yii::$app->getUser()->login($user)) {
//                return $this->goHome();
//            }
//        }
    }
//    public static function validatePassword($username, $password, $attribute)
//    {
////        if (!$this->hasErrors()) {
//            $user = $this->userRepository->getUserByUsername($username);
//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Incorrect username or password.');
//            }
////        }
//    }
}