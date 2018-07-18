<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 17.07.18
 * Time: 14:13
 */

use common\essences\Comment;
use yii\helpers\Html;
use yii\grid\GridView;
use common\essences\Category;
use yii\widgets\Pjax;

?>

<div class="comment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= $this->render('_form',[
        'comment' => $comment,
    ]) ?>

    <?php Pjax::begin(['id' => 'comments']) ?>
    <?php
    foreach ($dataProvider as $model) {
        echo $this->render('view', [
            'model' => $model
        ]);
    }
    ?>
    <?php Pjax::end() ?>
</div>
