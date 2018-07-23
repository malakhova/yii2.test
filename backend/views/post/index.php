<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'contentOptions' => ['style' => 'width: 10%; white-space: normal;'],
                'filter' => $authorFilter
            ],
            [
                'attribute' => 'title',
                'contentOptions' => ['style' => 'width: 10%; white-space: normal;'],
            ],
            [
                'attribute' => 'slug',
                'contentOptions' => ['style' => 'width: 10%; white-space: normal;'],
            ],
            [
                'attribute' => 'description',
                'contentOptions' => ['style' => 'width: 20%; white-space: normal;'],
            ],
            [
                'attribute' => 'content',
                'contentOptions' => ['style' => 'width: 50%; white-space: normal;'],
            ],

//            'content:ntext',
//            'description',

            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
