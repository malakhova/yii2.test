<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 16.07.18
 * Time: 15:25
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1 style="text-align: center">Блог</h1>

    <?php
    foreach ($dataProvider->models as $model) {
        echo $this->render('shortView', [
            'model' => $model
        ]);
    }
    ?>

</div>