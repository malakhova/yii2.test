<?php
namespace backend\controllers;

use common\services\AuthorizationService;
use Exception;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\forms\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private $authorizationService;


    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authorizationService = new AuthorizationService();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if($this->authorizationService->isUserAuthorized())
        {
            return $this->goHome();
        }

        $form = new LoginForm();

        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate())
            {
                $this->authorizationService->login($form);
                return $this->goBack();
            }
            else
            {
                return $this->render('login', [
                    'model' => $form,
                ]);
            }
        }
        catch (Exception $exception)
        {
//            Yii::$app->session->setFlash('error', 'Incorrect username or password.');
            $form->addError('password', 'Incorrect username or password.');
        }
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            $model->password = '';
//
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $this->authorizationService->logout();
        return $this->goHome();
    }
}
