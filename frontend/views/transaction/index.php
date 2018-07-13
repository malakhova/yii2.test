<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\forms\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid)
        {
            if($model->type == \common\essences\Transaction::TYPE_INCOME) {
                return ['style' => 'background-color:rgba(0,255,0,0.15); font-weight: bold;'];
                //return ['style' => 'background-color:rgba(0,255,0,0.15);'];
            } elseif ($model->type == \common\essences\Transaction::TYPE_EXPENSE){
                return ['style' => 'background-color:rgba(255,0,0,0.15); font-weight: bold;'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            [
//                'attribute' => 'user_id',
//                'value' => 'user.username',
//            ],
            [
                'attribute' => 'type',
                'value' => $types,
                'filter' => \common\essences\Transaction::getTypesByValue()
            ],
            [
                'attribute' => 'category_id',
                'value' => 'category.name',
                'filter' => \common\essences\Transaction::getCategoryList()
            ],
            [
                'attribute' => 'bill_id',
                'value' => 'bill.name',
                'filter' => \common\essences\Transaction::getBillList()
            ],
            'money',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
