<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 16.07.18
 * Time: 15:41
 */
use yii\helpers\Html;
?>
<head>
    <style type="text/css">
        .short-view {
            margin:10px;
            padding:10px;
            border: 1px solid #d5d9d4;
        }
        h1 {
            text-transform: uppercase;
            font-size: 16pt;
            font-weight: bold;
        }
        span {
            font-weight: bold;
            /*color: red;*/
        }

        .description {
            background-color: rgba(0, 0 , 1, 0.1);
        }

        .btn-more {
            margin: 5px 0;
        }

        .btn{
            padding: 5px 25px;
            /*text-transform: lowercase;*/
        }
    </style>
    <link rel="stylesheet" href="../../../backend/css/post.css" type="text/css"/>
<!--    <link  rel="stylesheet" type="text/css" href="../../css/post.css"/>-->
</head>
<body>
<div class="short-view">
    <h1><?= $model->title ?></h1>

    <div class="meta">
        <p><span class="author">Автор</span>: <?= $model->user->username ?> <br>
            <span>Дата публикации:</span> <?= $model->created_at ?> </p>
    </div>

    <div style="padding:10px;" class="description">
        <?= $model->description ?>
    </div>

    <div class="btn-more">
    <?= Html::a("More" , ['blog/'.$model->slug,
//        'slug' => $model->slug
    ],
        ['class' => 'btn btn-default']
    ) ?>
    </div>
</div>

</body>

