<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Comment */

?>

<head>
    <style type="text/css">
        .short-view {
            margin:10px 0;
            padding:10px;
            border: 1px solid rgb(213, 217, 212);
        }
        span {
            font-weight: bold;
            /*color: red;*/
        }

        .meta-comment {
            font-size: small;
        }

        .username {
            font-weight: bold;
        }

        .date {
            color: #7c7e7b;
        }
        .comment {
            background-color: rgba(0, 0 , 1, 0.05);
            padding:10px;
        }

        .btn-more {
            margin: 5px 0;
            float: right;
        }

        .btn{
            padding: 5px 25px;
            /*text-transform: lowercase;*/
        }
    </style>
    <link rel="stylesheet" href="../../css/post.css" type="text/css"/>
    <!--    <link  rel="stylesheet" type="text/css" href="../../css/post.css"/>-->
</head>
<body>
<div class="short-view">

    <div class="meta-comment">
        <div class="username"><?= $model->user->username ?></div>
        <div class="date"><?= $model->created_at ?></div>
    </div>

    <div class="comment">
        <?= $model->comment ?>
    </div>

    <a style="float: right;">Ответить</a>

    <div style="clear: both;"></div>
</div>

</body>
