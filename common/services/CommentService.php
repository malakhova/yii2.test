<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 15:11
 */

namespace common\services;

use common\essences\Comment;
use common\essences\Post;
use common\essences\User;
use common\repositories\DatabaseCommentRepository;
use common\repositories\DatabasePostRepository;
use common\repositories\DatabaseUserRepository;
use yii\helpers\ArrayHelper;

class CommentService
{
    private $userService;
    private $postService;

    private $commentRepository;
    private $userRepository;
    private $postRepository;

    public function __construct
    (
        UserService $userService,
        PostService $postService,
        DatabaseCommentRepository $commentRepository,
        DatabaseUserRepository $userRepository,
        DatabasePostRepository $postRepository
    )
    {
//        $this->userService = new UserService();
//        $this->postService = new PostService();

        $this->userService = $userService;
        $this->postService = $postService;

//        $this->commentRepository = new DatabaseCommentRepository();
//        $this->userRepository = new DatabaseUserRepository();
//        $this->postRepository = new DatabasePostRepository();

        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;

    }

    public function createBackendComment(){
        $comment = new Comment();
        $comment->created_at = date('Y.m.d H:i');
        return $comment;
    }

    public function createFrontendComment($postId)
    {
        $comment = new Comment();
        $comment->user_id = $this->userService->getCurrentUser();
        $comment->post_id = $postId;
        $comment->created_at = date('Y.m.d H:i');
        return $comment;
    }

    public function treeCommentsView($postId)
    {
        $treeComments = array();
//        $currentPostComments = Comment::find()->where(['post_id' => $postId])->all();
        $firstLevelComments = Comment::find()->where(['level' => 0])->andWhere(['post_id' => $postId])->all();
        foreach ($firstLevelComments as $comment)
        {
            $treeComments[] = $comment;
        }


        for ($level = 1; $level <= Comment::getMaxLevel(); $level++) {
            $oneLevelComments = Comment::find()->where(['level' => $level])->andWhere(['post_id' => $postId])->all();
            foreach ($oneLevelComments as $comment){
                for ($i = 0; $i < count($treeComments); $i++){
                    if($comment->parent_id == $treeComments[$i]->id) {
                        $key = $i+1;
                        array_splice($treeComments, $key, 0, array($comment));
                        break ;
                    }
                }

            }
        }

        return $treeComments;
    }



    public function findAllComments()
    {
        return $this->commentRepository->getAllComments();
    }

    public function findCommentById($id)
    {
        return $this->commentRepository->getCommentById($id);
    }



    public function findAuthorOfComment($comment) : User
    {
        return $this->userService->findUserById($comment->user_id);
    }

    public function findPostOfComment($comment) : Post
    {
        return $this->postService->findPostById($comment->post_id);
    }

    public function getUsernameOfAuthor($comment)
    {
        $user = $this->findAuthorOfComment($comment);
        return $user->username;
    }

    public function getTitleOfPost($comment)
    {
        $post = $this->findPostOfComment($comment);
        return $post->title;
    }

    public function getUsernameOfParentComment(Comment $comment)
    {
        if($replyUser = $this->findAuthorOfComment($comment->parent)){
            return $replyUser->username;
        } else throw new \Error("Comment doesn't have parent comment");
    }

    public function getCommentOfParentComment(Comment $comment)
    {
        $commentOfParentComment = $comment->parent->comment;
        if($commentOfParentComment){
            return $comment->parent->comment;
        } else throw new \Error("Comment doesn't have parent comment");

    }



    public function setCommentLevel(Comment $comment)
    {
        if($comment->parent_id) {
            $parentLevel = $comment->parent->level;
            $comment->level = $parentLevel + 1;
        }
        else {
            $comment->level = 0;
        }

        $comment->save();
    }

    public function allChildComments(Comment $comment)
    {
        $parentCommentId = $comment->id;
        $allChildComments = Comment::find()->where(['parent_id' => $parentCommentId])->all();
        if($allChildComments){
            return $allChildComments;
        } else {
            throw new \Exception("Comment doesn't have child comments");
        }

    }

    public function updateLevelOfChildComments(Comment &$comment)
    {
        $parentCommentId = $comment->id;
        $parentCommentLevel= $comment->level;
        $allChildComments = $this->allChildComments($comment);
        foreach ($allChildComments as $childComment)
        {
            $childComment->level = $parentCommentLevel;
            $childComment->save();
        }
    }

    public function createListOfCommentParents(int $post)
    {
        $comments = Comment::find()
            ->where('post_id=:post', [':post' => $post])
            ->all();

        $option ="";
        $option .= '<option value="'.null.'">'.'Не ответ / оригинальный комментарий '.'</option>';
        foreach($comments as $comment){
            $option .= '<option value="'.$comment->id.'">'.$comment->user->username.': '.$comment->comment.'</option>';
        }
        return $option;
    }

    public function filterAuthorList()
    {
        $userList = array();
        $allComments = $this->commentRepository->getAllComments();
        foreach ($allComments as $comment)
        {
            if(!in_array($comment, $userList))
            {
                $userList[] = $this->findAuthorOfComment($comment);
            }
        }
        $list = ArrayHelper::map($userList, 'id', 'username');
        return $list;
    }
}