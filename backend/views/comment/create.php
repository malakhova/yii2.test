<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $comment common\essences\Comment */

$this->title = 'Create Comment';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'comment' => $comment,
        'users' => $users,
        'posts' => $posts,
        'comments' => $comments,
    ]) ?>

</div>
