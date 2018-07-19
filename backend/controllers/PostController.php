<?php

namespace backend\controllers;

use common\services\PostService;
use common\services\UserService;
use Yii;
use common\essences\Post;
use backend\forms\PostSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    private $postService;
    private $userService;
    private $users;

    public function __construct(string $id, Module $module, PostService $postService, UserService $userService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->postService = $postService;
        $this->userService = $userService;

        $this->users = $this->userService->findAllUsers();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $authorFilter = $this->postService->filterAuthorList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'authorFilter' => $authorFilter
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $post = $this->postService->findPostById($id);
        $username = $this->postService->getUsernameOfAuthor($post);
        return $this->render('view', [
            'post' => $post,
            'username' => $username,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $post = $this->postService->createBackendPost();

        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            return $this->redirect(['view', 'id' => $post->id]);
        }

        return $this->render('create', [
            'post' => $post,
            'users' => $this->users
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $post = $this->postService->findPostById($id);

        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            return $this->redirect(['view', 'id' => $post->id]);
        }

        return $this->render('update', [
            'model' => $post,
            'users' => $this->users
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $post = $this->postService->findPostById($id);
        $post->delete();
        return $this->redirect(['index']);
    }

}
