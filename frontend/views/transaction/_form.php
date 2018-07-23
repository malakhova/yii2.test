<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\essences\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--    --><? //= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList($types,
        [
            'prompt' => 'Выбрать тип...',
            'onchange' => '
                  $.post(
                  "' . Url::toRoute('category/list') . '",
                  {type : $(this).val()},
                  function(data){
                      $("select#category").html(data).attr("disabled", false)
                  }
                  )
            '
        ]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map($categories, 'id', 'name'),
        [
            'prompt' => 'Выбрать категорию...',
            'id' => 'category',
            'disabled' => $model->isNewRecord ? 'disabled' : false

        ]) ?>

    <?= $form->field($model, 'bill_id')->dropDownList(
        ArrayHelper::map($bills, 'id', 'name')) ?>

    <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->widget(DateTimePicker::className(), [
        'name' => 'dp_1',
        'type' => DateTimePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Ввод даты/времени...'],
        'convertFormat' => true,
        'value' => date("Y.m.d h:i", (integer)$model->created_at),
        'pluginOptions' => [
            'format' => 'yyyy.MM.dd hh:i',
            'autoclose' => true,
            'weekStart' => 1, //неделя начинается с понедельника
            'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
            'todayBtn' => true, //снизу кнопка "сегодня"
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
