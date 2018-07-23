<?php

namespace frontend\controllers;

use common\services\CommentService;
use frontend\forms\CommentSearch;
use Yii;
use yii\base\Module;

class CommentController extends \yii\web\Controller
{

    private $commentService;

    public function __construct(string $id,
                                Module $module,
                                CommentService $commentService,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->commentService = $commentService;
    }

    public function actionIndex($postId)
    {
        $searchModel = new CommentSearch();
        $dataProvider = $this->commentService->treeCommentsView($postId);
        $comment = $this->commentService->createFrontendComment($postId);

        if ($comment->load(Yii::$app->request->post()) && $comment->save())
        {
            $comment = $this->commentService->createFrontendComment($postId);
        }
        return $this->render('index',[
            'comment' => $comment,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,]);
    }

}
