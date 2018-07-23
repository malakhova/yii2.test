<?php

namespace frontend\controllers;

use common\forms\LoginForm;
use common\services\AuthorizationService;
use Exception;
use frontend\forms\ContactForm;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResetPasswordForm;
use frontend\forms\SignupForm;
use frontend\services\ContactService;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private $contactService;
    private $authorizationService;

    /**
     * {@inheritdoc}
     */


    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->contactService = new ContactService(Yii::$app->params['adminEmail'], Yii::$app->mailer);
        $this->authorizationService = new AuthorizationService();
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if ($this->authorizationService->isUserAuthorized()) {
            return $this->goHome();
        }

        $form = new LoginForm();

        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $this->authorizationService->login($form);
                return $this->goBack();
            } else {
                return $this->render('login', [
                    'model' => $form,
                ]);
            }
        } catch (Exception $exception) {
//            Yii::$app->session->setFlash('error', 'Incorrect username or password.');
            $form->addError('password', 'Incorrect username or password.');
        }

    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $this->authorizationService->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->contactService->getSendStatus($form);
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $form,
            ]);
        }


    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $form = new SignupForm();
        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $this->authorizationService->signup($form);
                return $this->goHome();
            }
        } catch (Exception $exception) {

        }
        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error',
                    'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
