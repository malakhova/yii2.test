<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 16:52
 */

namespace common\repositories;


use common\essences\Post;

interface PostRepository
{
    public function getPostById($id) : Post;
    public function getPostBySlug($id) : Post;
    public function getListOfPosts();
    public function getAllPosts();
}