<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\essences\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList($types,
        [
            'prompt' => 'Выбрать тип...',
            'onchange' => '
                  $.post(
                  "'.Url::toRoute('category/parents-list').'",
                  {type : $(this).val()},
                  function(data){
                      $("select#category").html(data).attr("disabled", false)
                  }
                  )
            '
        ]) ?>
    <?= Html::checkbox('newParent', false, [
            'label' => 'Создать родительскую категорию',

    ]) ?>
    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($parents, 'id', 'name'),
        [
            'prompt' => 'Выбрать категорию...',
            'id' => 'category',
//            'disabled' => 'namePa' ? 'disabled' : false
            'disabled' => $model->isNewRecord ? 'disabled' : false

        ]) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
