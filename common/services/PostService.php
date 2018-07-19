<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 16:49
 */
namespace common\services;

use common\essences\Post;
use common\essences\User;
use common\repositories\DatabasePostRepository;
use common\repositories\DatabaseUserRepository;

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
    )
    {
        $this->userService = $userService;

        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;

    }

    public function createBackendPost()
    {
        return new Post();
    }

    public function findPostById($id)
    {
        return $this->postRepository->getPostById($id);

    }

    public function findPostBySlug($slug) : Post
    {
        return $this->postRepository->getPostBySlug($slug);

    }

    public function filterList()
    {
        return $this->postRepository->getListOfPosts();
    }

    public function findAllPosts()
    {
        return $this->postRepository->getAllPosts();
    }

    public function findAuthorOfPost($post) : User
    {
        return $this->userService->findUserById($post->user_id);
    }

    public function getUsernameOfAuthor($post)
    {
        $user = $this->findAuthorOfPost($post);
        return $user->username;
    }

}