<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\essences\Comment */

$this->title = $comment->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $comment->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $comment->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $comment,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => $authorUsername,
            ],
            [
                'attribute' => 'post_id',
                'value' => $postTitle,
            ],
            [
                'label' => 'В ответ пользователю',
                'attribute' => 'parent_id',
                'value' => $usernameOfParentComment,
            ],
            [
                'attribute' => 'parent_id',
                'value' => $commentOfParentComment,
            ],
            'level',
            'comment',
            'created_at',
        ],
    ]) ?>

</div>
