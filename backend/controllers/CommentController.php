<?php

namespace backend\controllers;

use common\essences\Post;
use common\essences\User;
use common\services\CommentService;
use common\services\PostService;
use common\services\UserService;
use Exception;
use Yii;
use common\essences\Comment;
use backend\forms\CommentSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    private $commentService;
    private $postService;
    private $userService;

    private $users;
    private $posts;
    private $comments;

    public function __construct(string $id, Module $module, CommentService $commentService, PostService $postService, UserService $userService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->commentService = $commentService;
        $this->postService = $postService;
        $this->userService = $userService;

        $this->users = $this->userService->findAllUsers();
        $this->posts =  $this->postService->findAllPosts();
        $this->comments =  $this->commentService->findAllComments();
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
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $postsFilter = $this->postService->filterList();
        $userFilter = $this->commentService->filterAuthorList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'postsFilter' => $postsFilter,
            'userFilter' => $userFilter
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $comment = $this->commentService->findCommentById($id);

        $authorUsername = $this->commentService->getUsernameOfAuthor($comment);
        $postTitle = $this->commentService->getTitleOfPost($comment);

        try {
            $usernameOfParentComment = $this->commentService->getUsernameOfParentComment($comment);
            $commentOfParentComment = $this->commentService->getCommentOfParentComment($comment);
        }
        catch (Exception $exception)
        {
            $usernameOfParentComment = null;
            $commentOfParentComment = null;
        }


        return $this->render('view', [
            'comment' => $comment,
            'authorUsername' => $authorUsername,
            'postTitle' => $postTitle,
            'usernameOfParentComment' => $usernameOfParentComment,
            'commentOfParentComment' => $commentOfParentComment,
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $comment = $this->commentService->createBackendComment();


        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            $this->commentService->setCommentLevel($comment);
            return $this->redirect(['view', 'id' => $comment->id]);
        }

        return $this->render('create', [
            'comment' => $comment,
            'users' => $this->users,
            'posts' => $this->posts,
            'comments' => $this->comments,
        ]);
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $comment = $this->commentService->findCommentById($id);


        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            return $this->redirect(['view', 'id' => $comment->id]);
        }

        return $this->render('update', [
            'comment' => $comment,
            'users' => $this->users,
            'posts' => $this->posts,
            'comments' => $this->comments,
        ]);
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try
        {
            $comment = $this->commentService->findCommentById($id);
        }
        catch (Exception $exception)
        {
            return $this->redirect(['index']);
        }

        try
        {
            $parentCommentLevel= $comment->level;
            $parentCommentParent= $comment->parent_id;
            $allChildComments = $this->commentService->allChildComments($comment);

        }
        catch (Exception $exception)
        {
            $comment->delete();
            return $this->redirect(['index']);
        }
        foreach ($allChildComments as $childComment)
        {
            $childComment->parent_id = $parentCommentParent;
            $childComment->level = $parentCommentLevel;
            $childComment->save();
        }

        $comment->delete();
        return $this->redirect(['index']);
    }


    /* @var $comment Comment*/
    public function actionCreateListOfCommentParents()
    {

        if(Yii::$app->request->isAjax)
        {
            $post = (int)Yii::$app->request->post('post');
            $option = $this->commentService->createListOfCommentParents($post);
        }

        return $option;
    }
}
