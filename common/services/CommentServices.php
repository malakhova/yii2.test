<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 15:11
 */

namespace common\services;

use common\essences\Comment;

class CommentServices
{
    private $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function createComment($postId)
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



}