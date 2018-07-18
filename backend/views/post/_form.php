<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


<!--    --><?//= $form->field($model, 'created_at')->widget(DateTimePicker::className(),[
//        'name' => 'dp_1',
//        'type' => DateTimePicker::TYPE_INPUT,
//        'options' => ['placeholder' => 'Ввод даты/времени...'],
//        'convertFormat' => true,
//        'value'=> date("Y.m.d h:i",(integer) $model->created_at),
//        'pluginOptions' => [
//            'format' => 'yyyy.MM.dd hh:i',
//            'autoclose'=>true,
//            'weekStart'=>1, //неделя начинается с понедельника
//            'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
//            'todayBtn'=>true, //снизу кнопка "сегодня"
//        ]
//    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
