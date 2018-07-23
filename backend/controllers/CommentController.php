<?php

namespace backend\controllers;

use backend\forms\CommentSearch;
use common\essences\Comment;
use common\repositories\DatabaseCommentRepository;
use common\repositories\DatabasePostRepository;
use common\repositories\DatabaseUserRepository;
use common\services\CommentService;
use common\services\PostService;
use Exception;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    private $commentService;
    private $postService;

    private $userRepository;
    private $postRepository;
    private $commentRepository;

    private $users;
    private $posts;
    private $comments;

    public function __construct(
        string $id,
        Module $module,
        CommentService $commentService,
        PostService $postService,
        DatabaseUserRepository $userRepository,
        DatabasePostRepository $postRepository,
        DatabaseCommentRepository $commentRepository,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->commentService = $commentService;
        $this->postService = $postService;

        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;

        $this->users = $this->userRepository->getAllUsers();
        $this->posts = $this->postRepository->getAllPosts();
        $this->comments = $this->commentRepository->getAllComments();
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

//        $postsFilter = $this->postRepository->getListOfPosts();
//        $userFilter = $this->commentService->filterAuthorList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'postsFilter' => $postsFilter,
//            'userFilter' => $userFilter
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
        $comment = $this->commentRepository->getCommentById($id);

        $authorUsername = $this->commentService->getUsernameOfAuthor($comment);
        $postTitle = $this->commentService->getTitleOfPost($comment);

        try {
            $usernameOfParentComment = $this->commentService->getUsernameOfParentComment($comment);
            $commentOfParentComment = $this->commentService->getCommentOfParentComment($comment);
        } catch (Exception $exception) {
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
        $comment = $this->commentRepository->getCommentById($id);


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
        try {
            $comment = $this->commentRepository->getCommentById($id);
        } catch (Exception $exception) {
            return $this->redirect(['index']);
        }

        try {
            $this->commentService->updateLevelOfChildComments($comment);

        } catch (Exception $exception) {
            $comment->delete();
            return $this->redirect(['index']);
        }

        $comment->delete();
        return $this->redirect(['index']);
    }


    /* @var $comment Comment */
    public function actionCreateListOfCommentParents()
    {

        if (Yii::$app->request->isAjax) {
            $postId = (int)Yii::$app->request->post('postId');
            $option = $this->commentService->createListOfCommentParents($postId);
        }

        return $option;
    }
}
