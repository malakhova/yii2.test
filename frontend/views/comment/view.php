<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $comment common\essences\Comment */

$currentUserID = Yii::$app->user->id;
$colorUsername = "";
if($comment->user_id == $currentUserID) {
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
<div class="short-view" style="margin-left: <?=$marginLevel = 15*$comment->level?>px">

    <div class="meta-comment">

        <div class="username" style=" color: <?= $colorUsername?>;"><?= $comment->user->username ?></div>

        <div class="date"><?= $comment->created_at ?></div>
        <?php
        if($comment->parent_id != null) {
            $usernameParentComment = $comment->parent->user->username;
            echo "<div class=\"reply-to\">"."в ответ "."<span class='reply-to-username'>"."$usernameParentComment"."</span> </div>";
        }
        ?>
    </div>

    <div class="comment">
        <?= $comment->comment ?>
    </div>

    <?= Html::a("Ответить" ,null,  ['class' => 'reply']
//        ['id' => $comment->id]
    ) ?>

    <div style="clear: both;"></div>
</div>

</body>
