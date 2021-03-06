<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 17.07.18
 * Time: 14:13
 */

use yii\widgets\Pjax;

?>

<div class="comment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= $this->render('_form', [
        'comment' => $comment,
    ]) ?>

    <?php Pjax::begin(['id' => 'comments']) ?>
    <?php
    foreach ($dataProvider as $comment) {
        echo $this->render('view', [
            'comment' => $comment
        ]);
    }
    ?>
    <?php Pjax::end() ?>
</div>
