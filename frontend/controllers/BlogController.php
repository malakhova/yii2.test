<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 16.07.18
 * Time: 15:21
 */

namespace frontend\controllers;

use common\essences\Comment;
use common\services\CommentServices;
use common\services\PostServices;
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

    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->commentService = new CommentServices();
        $this->postService = new PostServices();
        $this->userService = new UserService();
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
        $post = $this->postService->findPostBySlug($slug);
        $post_id = $post->id;
        $searchModel = new CommentSearch();
        $dataProvider = $this->commentService->treeCommentsView($post_id);


        $comment = $this->commentService->createComment($post_id);

        if ($comment->load(Yii::$app->request->post()) && $comment->save())
        {
            $comment = $this->commentService->createComment($post_id);
        }

        return $this->render('view', [
            'post' => $post,
            'comment' => $comment,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}