<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $comment common\essences\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#new_comment").on("pjax:end", function() {
                $.pjax.reload({container:"#comments"});  //Reload GridView
            });
        });'
);
?>


<div class="comment-form">
    <?php yii\widgets\Pjax::begin(['id' => 'new_comment']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <?php
    if ($comment->parent_id != null) {
        $usernameParentComment = $comment->parent->user->username;
        echo "<div class=\"reply-to\">" . "в ответ " . "<span class='reply-to-username'>" . "$usernameParentComment" . "</span> </div>";
    }
    ?>
    <?= $form->field($comment, 'comment')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>