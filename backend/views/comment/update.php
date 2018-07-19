<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $comment common\essences\Comment */

$this->title = 'Update Comment: ' . $comment->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $comment->id, 'url' => ['view', 'id' => $comment->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'comment' => $comment,
        'users' => $users,
        'posts' => $posts,
        'comments' => $comments,
    ]) ?>

</div>
