<?php
/**
 * Created by PhpStorm.
 * User: georgy
 * Date: 09.07.14
 * Time: 9:26
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $post common\essences\Post */
/* @var $comment  common\essences\Comment */
$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <style type="text/css">
        h1 {
            margin-bottom: 0;
            text-transform: uppercase;
            font-size: 16pt;
            font-weight: bold;
        }
        span {
            font-weight: bold;
            /*color: red;*/
        }

        .meta {
            text-transform: lowercase;
            color: rgba(0, 0 , 1, 0.5);
        }

        .content {
            background-color: rgba(0, 0 , 1, 0.05);
            margin: 10px 0;
            padding: 10px 20px;
            white-space: pre-wrap;
        }

        .add-comment{
            background-color:rgba(0, 0 , 0, 0.05);
            border-radius:3px;
            padding: 10px 20px;
        }
    </style>
    <link rel="stylesheet" href="../../../backend/css/post.css" type="text/css"/>
</head>
<body>
    <h1><?= $post->title ?></h1>
    <div class="meta">
        <p> <?= $post->user->username ?>, <?= $post->created_at ?> </p>
    </div>

    <div class="content">
        <?= $post->content ?>
    </div>

    <div class="add-comment">
        <?=
        $this->render('../comment/index',[
            'comment' => $comment,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,]);
        ?>
    </div>
</body>


