<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 19.07.18
 * Time: 10:55
 */

namespace common\repositories;


use common\essences\Comment;

interface CommentRepository
{
    public function getCommentById($id): Comment;

    public function getAllComments();

    public function getAllCommentsOfPost($postId);

    public function getOneLevelCommentsOfPost($postId, $level);

    public function getMaxLevel(): int;
}