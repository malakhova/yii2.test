<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 18.07.18
 * Time: 16:56
 */

namespace common\repositories;


use common\essences\Post;
use Error;
use yii\helpers\ArrayHelper;

class DatabasePostRepository implements PostRepository
{

    public function getPostById($id): Post
    {
        // TODO: Implement getPostById() method.
        if (($post = Post::findOne($id)) !== null) {
            return $post;
        }
        throw new Error("Post not found in Database");
    }


    public function getPostBySlug($slug): Post
    {
        // TODO: Implement getPostBySlug() method.
        if (($post = Post::findOne(['slug' => $slug])) !== null) {
            return $post;
        }
        throw new Error("Post not found in Database");
    }


    public function getListOfPosts()
    {
        // TODO: Implement getListOfPosts() method.
        $posts = Post::find()->with(['user'])->all();
        $list = ArrayHelper::map($posts, 'id', 'title');
        return $list;
    }

    public function getAllPosts()
    {
        // TODO: Implement getAllPosts() method.
        return Post::find()->with(['user'])->all();
    }

}