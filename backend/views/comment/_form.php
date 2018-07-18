<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\essences\Comment */
/* @var $form yii\widgets\ActiveForm */

/* @var $comments common\essences\Comment */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', 'username')) ?>

    <?= $form->field($model, 'post_id')->dropDownList(ArrayHelper::map($posts, 'id', 'title'),
        [
            'prompt' => 'Выбрать пост...',
            'onchange' => '
                  $.post(
                  "'.Url::toRoute('comment/parents-list').'",
                  {post : $(this).val()},
                  function(data){
                      $("select#comments").html(data).attr("disabled", false)
                  }
                  )
            '
        ]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($comments, 'id', 'user_id'),
        [
            'prompt' => 'Выбрать категорию...',
            'id' => 'comments',
            'disabled' => $model->isNewRecord ? 'disabled' : false

        ]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
