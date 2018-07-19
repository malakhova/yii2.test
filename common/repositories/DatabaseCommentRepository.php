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
        throw new Error("Post not found in Database");
    }


    public function getAllComments()
    {
        // TODO: Implement getAllComments() method.
        return Post::find()->all();
    }

}