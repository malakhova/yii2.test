<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 16.07.18
 * Time: 15:25
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Блог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1 class="caption"
         style="
         text-align: center;
         font-size: 24pt;
"
    >
        Блог
    </h1>

    <?php
    foreach (array_reverse($dataProvider->models) as $post) {
        echo $this->render('shortView', [
            'post' => $post
        ]);
    }
    ?>

</div>