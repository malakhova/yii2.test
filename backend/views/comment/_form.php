<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $comment common\essences\Comment */
/* @var $form yii\widgets\ActiveForm */

/* @var $comments common\essences\Comment */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($comment, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', 'username')) ?>

    <?= $form->field($comment, 'post_id')->dropDownList(ArrayHelper::map($posts, 'id', 'title'),
        [
            'prompt' => 'Выбрать пост...',
            'onchange' => '
                  $.post(
                  "'.Url::toRoute('comment/create-list-of-comment-parents').'",
                  {post : $(this).val()},
                  function(data){
                      $("select#comments").html(data).attr("disabled", false)
                  }
                  )
            '
        ]) ?>

    <?= $form->field($comment, 'parent_id')->dropDownList(ArrayHelper::map($comments, 'id', 'user_id'),
        [
            'prompt' => 'Выбрать комментарий...',
            'id' => 'comments',
            'disabled' => $comment->isNewRecord ? 'disabled' : false

        ]) ?>

    <?= $form->field($comment, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
