<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\essences\Category */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'parents' => $parents,
        'types' => $types
    ]) ?>

</div>
