<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Comment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'post_id',
                'value' => 'post.title',
                'filter' => $postsFilter
            ],
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'filter' => $usersFilter
            ],

            [
                'label' => 'В ответ пользователю',
                'attribute' => 'parent_id',
                'value' => 'parent.user.username',
            ],
            [
                'attribute' => 'parent_id',
                'value' => 'parent.comment',
                'contentOptions' => ['style' => 'width: 20%; white-space: normal;'],
            ],
//            'level',
            [
                'attribute' => 'comment',
                'contentOptions' => ['style' => 'width: 30%; white-space: normal;'],
            ],
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
