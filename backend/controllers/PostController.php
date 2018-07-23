<?php

namespace backend\controllers;

use backend\forms\PostSearch;
use common\repositories\DatabasePostRepository;
use common\repositories\DatabaseUserRepository;
use common\services\PostService;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    private $postService;

    private $userRepository;
    private $postRepository;

    private $users;

    public function __construct(
        string $id,
        Module $module,
        PostService $postService,
        DatabaseUserRepository $userRepository,
        DatabasePostRepository $postRepository,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->postService = $postService;

        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;

        $this->users = $this->userRepository->getAllUsers();
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
        $post = $this->postRepository->getPostById($id);
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
        $post = $this->postRepository->getPostById($id);

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
        $post = $this->postRepository->getPostById($id);
        $post->delete();
        return $this->redirect(['index']);
    }

}
