<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 15:11
 */

namespace common\services;

use common\essences\Comment;
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
    ) {

        $this->userService = $userService;
        $this->postService = $postService;

        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;

    }

    public function createBackendComment()
    {
        $comment = new Comment();
        $comment->created_at = date('Y.m.d H:i:s');
        return $comment;
    }

    public function createFrontendComment($postId)
    {
        $comment = new Comment();
        $comment->user_id = $this->userService->getCurrentUser();
        $comment->post_id = $postId;
        $comment->created_at = date('Y.m.d H:i:s');
        return $comment;
    }

    public function treeCommentsView($postId)
    {
        $treeComments = array();
        $allCommentsOfPost = $this->commentRepository->getAllCommentsOfPost($postId);
        $originalComments = $this->oneLevelCommentsOfPost($allCommentsOfPost, 0);

//        $treeComments = array_merge($treeComments,$originalComments);

        foreach ($originalComments as $comment) {
            $treeComments[] = $comment;
        }

        $maxLevel = $this->commentRepository->getMaxLevel();
        for ($level = 1; $level <= $maxLevel; $level++) {
            $oneLevelComments = $this->oneLevelCommentsOfPost($allCommentsOfPost, $level);
            for ($i = 0; $i < count($treeComments); $i++) {
                $parentId = $treeComments[$i]->id;
                $oneParentComments = $this->oneParentCommentsOfPost($oneLevelComments, $parentId);
                $key = $i + 1;
                array_splice($treeComments, $key, 0, $oneParentComments);
            }
        }

        return $treeComments;
    }

    public function oneLevelCommentsOfPost($comments, int $level)
    {
        $oneLevelComments = array();
        foreach ($comments as $comment) {
            if ($comment->level == $level) {
                $oneLevelComments[] = $comment;
            }
        }
        return $oneLevelComments;
    }

    public function oneParentCommentsOfPost($comments, int $parentId)
    {
        $oneParentComments = array();
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                $oneParentComments[] = $comment;
            }
        }
        return $oneParentComments;
    }

    public function getUsernameOfAuthor(Comment $comment)
    {
        return $comment->user->username;
    }

    public function getTitleOfPost(Comment $comment)
    {
//        $post = $this->findPostOfComment($comment);
        return $comment->post->title;
    }

    public function getUsernameOfParentComment(Comment $comment)
    {
        if ($replyUser = $comment->parent->user) {
            return $replyUser->username;
        } else {
            throw new \Error("Comment doesn't have parent comment");
        }
    }

    public function getCommentOfParentComment(Comment $comment)
    {
        $commentOfParentComment = $comment->parent->comment;
        if ($commentOfParentComment) {
            return $comment->parent->comment;
        } else {
            throw new \Error("Comment doesn't have parent comment");
        }

    }

    public function setCommentLevel(Comment $comment)
    {
        if ($comment->parent_id) {
            $parentLevel = $comment->parent->level;
            $comment->level = $parentLevel + 1;
        } else {
            $comment->level = 0;
        }

        $comment->save();
    }

    public function updateLevelOfChildComments(Comment $comment)
    {
        $parentCommentLevel = $comment->level;
        $parentCommentParent = $comment->parent_id;
        try {
            $allChildComments = $this->allChildComments($comment);
        } catch (\Exception $exception) {
            throw new \Exception("Comment doesn't need update child comments");
        }
        foreach ($allChildComments as $childComment) {
            $childComment->parent_id = $parentCommentParent;
            $childComment->level = $parentCommentLevel;
            $childComment->save();
        }
    }

    public function allChildComments(Comment $comment)
    {
        $parentCommentId = $comment->id;
        $allChildComments = Comment::find()->with(['user', 'post'])->where(['parent_id' => $parentCommentId])->all();
        if ($allChildComments) {
            return $allChildComments;
        } else {
            throw new \Exception("Comment doesn't have child comments");
        }

    }

    public function createListOfCommentParents(int $postId)
    {
        $comments = Comment::find()
            ->with(['user', 'post'])
            ->where('post_id=:postId', [':postId' => $postId])
            ->all();

        $option = "";
        $option .= '<option value="' . null . '">' . 'Не ответ / оригинальный комментарий ' . '</option>';
        foreach ($comments as $comment) {
            $option .= '<option value="' . $comment->id . '">' . $comment->user->username . ': ' . $comment->comment . '</option>';
        }
        return $option;
    }

    public function filterAuthorList()
    {
        $userList = array();
        $allComments = $this->commentRepository->getAllComments();
        foreach ($allComments as $comment) {
//            if(!in_array($comment, $userList))
//            {
            $userList[] = $comment->user;
//            }
        }
        $list = ArrayHelper::map($userList, 'id', 'username');
        return $list;
    }
}