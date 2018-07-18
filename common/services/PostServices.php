<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 16:49
 */
namespace common\services;

use common\essences\Post;
use common\repositories\DatabasePostRepository;

class PostServices
{
    private $postRepository;

    public function __construct()
    {
        $this->postRepository = new DatabasePostRepository();
    }

    public function findPostById($id)
    {
        return $this->postRepository->getPostById($id);

    }

    public function findPostBySlug($slug) : Post
    {
        return $this->postRepository->getPostBySlug($slug);

    }

}