<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 16.07.18
 * Time: 15:21
 */

namespace frontend\controllers;

use common\essences\Comment;
use common\repositories\DatabasePostRepository;
use common\services\CommentService;
use common\services\PostService;
use common\services\UserService;
use frontend\forms\CommentSearch;
use Yii;
use common\essences\Post;
use frontend\forms\PostSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BlogController extends Controller
{
    private $userService;
    private $commentService;
    private $postService;

    private $postRepository;

    public function __construct(string $id, Module $module, CommentService $commentService, PostService $postService, UserService $userService, DatabasePostRepository $postRepository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->commentService = $commentService;
        $this->postService = $postService;
        $this->userService = $userService;

        $this->postRepository = $postRepository;
    }

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


    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSlug($slug)
    {
        $post = $this->postRepository->getPostBySlug($slug);
        $postId = $post->id;

        $searchModel = new CommentSearch();
        $dataProvider = $this->commentService->treeCommentsView($postId);


        $comment = $this->commentService->createFrontendComment($postId);

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            $comment = $this->commentService->createFrontendComment($postId);
        }

        return $this->render('view', [
            'post' => $post,
            'comment' => $comment,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}