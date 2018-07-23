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
use common\repositories\DatabaseUserRepository;
use yii\helpers\ArrayHelper;

class PostService
{
    private $userService;

    private $postRepository;
    private $userRepository;

    public function __construct
    (
        UserService $userService,
        DatabasePostRepository $postRepository,
        DatabaseUserRepository $userRepository
    ) {
        $this->userService = $userService;

        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;

    }

    public function createBackendPost()
    {
        return new Post();
    }


    public function filterAuthorList()
    {
        $authorList = array();
        $allPosts = $this->postRepository->getAllPosts();
        foreach ($allPosts as $post) {
//            if(!in_array($post, $authorList))
//            {
            $authorList[] = $post->user;
//            }
        }
        $list = ArrayHelper::map($authorList, 'id', 'username');
        return $list;
    }

    public function findAllPosts()
    {
        return $this->postRepository->getAllPosts();
    }


    public function getUsernameOfAuthor(Post $post)
    {
        return $post->user->username;
    }

    public function getCreatedDate(Post $post)
    {
        return $post->created_at;
    }

}