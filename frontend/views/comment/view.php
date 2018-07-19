<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\essences\Comment */

$currentUserID = Yii::$app->user->id;
$colorUsername = "";
if($model->user_id == $currentUserID) {
    $colorUsername = "#2A52BE";
}


?>

<head>
    <style type="text/css">
        .short-view {
            margin: 10px 0;
            padding: 10px;
            /*padding-left: ;*/
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

        .reply {
            float: right;
        }

        .reply-to {
            color: #6d6f6c;
        }

        .reply-to-username {
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="../../../backend/css/post.css" type="text/css"/>
</head>
<body>
<div class="short-view" style="margin-left: <?=$marginLevel = 15*$model->level?>px">

    <div class="meta-comment">

        <div class="username" style=" color: <?= $colorUsername?>;"><?= $model->user->username ?></div>

        <div class="date"><?= $model->created_at ?></div>
        <?php
        if($model->parent_id != null) {
            $usernameParentComment = $model->parent->user->username;
            echo "<div class=\"reply-to\">"."в ответ "."<span class='reply-to-username'>"."$usernameParentComment"."</span> </div>";
        }
        ?>
    </div>

    <div class="comment">
        <?= $model->comment ?>
    </div>

    <?= Html::a("Ответить" , ['comment/_form'], ['class' => 'reply'],
        ['id' => $model->id]
    ) ?>

    <div style="clear: both;"></div>
</div>

</body>
