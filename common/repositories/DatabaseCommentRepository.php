<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 19.07.18
 * Time: 10:56
 */

namespace common\repositories;


use common\essences\Comment;
use common\essences\Post;
use Error;

class DatabaseCommentRepository implements CommentRepository
{

    public function getCommentById($id): Comment
    {
        // TODO: Implement getCommentById() method.
        if (($comment = Comment::findOne($id)) !== null) {
            return $comment;
        }
        throw new \Exception("Comment not found in Database");
    }


    public function getAllComments()
    {
        // TODO: Implement getAllComments() method.
        return Comment::find()
            ->with(['user'])
            ->with(['post'])
            ->with(['parent'])
            ->with(['parent.user'])
            ->all();
    }

    public function getAllCommentsOfPost($postId)
    {
        // TODO: Implement getAllCommentsOfPost() method.
        return Comment::find()
            ->with(['user'])
            ->with(['post'])
            ->with(['parent'])
            ->with(['parent.user'])
            ->andWhere(['post_id' => $postId])
            ->all();
    }


    public function getOneLevelCommentsOfPost($postId, $level)
    {
        $query = Comment::find()
            ->with(['user'])
            ->with(['post'])
            ->with(['parent'])
            ->with(['parent.user']);

        // TODO: Implement getOneLevelCommentsOfPost() method.
        return $query
                ->where(['level' => $level])
                ->andWhere(['post_id' => $postId])
                ->orderBy('id')
                ->all();
    }


    public function getMaxLevel(): int
    {
        // TODO: Implement getMaxLevel() method.
        return Comment::find()
            ->with(['user','post'])
            ->max('level');
    }
}