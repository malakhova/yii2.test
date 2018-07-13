<?php

namespace frontend\controllers;

use DateTime;
use common\essences\Bill;
use common\essences\Category;
use common\essences\User;
use Yii;
use common\essences\Transaction;
use frontend\forms\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $types = function($model, $key, $index, $column)  {
            return $model->getTypesByValue()[$model->type];};

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'types' => $types,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if($user = User::findOne($model->user_id)){
            $userName = $user->username;
        }
        $types =  $model->getTypesByValue()[$model->type];
        if($bill = Bill::findOne($model->bill_id)){
            $billName = $bill->name;
        }
        if($category = Category::findOne($model->category_id)){
            $categoryName = $category->name;
        }
        return $this->render('view', [
            'model' => $model,
            'types' => $types,
            'categoryName' => $categoryName,
            'billName' => $billName,
            'userName' => $userName
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();
        $types =  $model->getTypesByValue();
        $categories = Category::find()->all();

        /** @var frontend\essences\User $userModel */
        $currentUserID = Yii::$app->user->id;
        $model->user_id = $currentUserID;

        $bills = Bill::find()->all();



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $bill = Bill::findOne($model->bill_id);
            if($model->type == Transaction::TYPE_EXPENSE){
                $bill->money -= $model->money;
                $bill->update();
            } elseif ($model->type == Transaction::TYPE_INCOME){
                $bill->money += $model->money;
                $bill->update();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'types' => $types,
            'categories' => $categories,
            'bills' => $bills
        ]);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // списки для выбора
        $types =  $model->getTypesByValue();
        $categories = Category::find()->all();
        $bills = Bill::find()->all();

        // текущие значения
        $currentBill = Bill::findOne($model->bill_id);  //счёт
        $currentTransactionMoney = $model->money;       //использованные средства
        $currentType = $model->type;                    //тип операции


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // возращаем значение счёта в состояние без использованной суммы
            if($currentType == Transaction::TYPE_EXPENSE){   // если был расход - добавляем к счёту деньги
                $currentBill->money += $currentTransactionMoney;
                $currentBill->update();
            }elseif ($currentType == Transaction::TYPE_INCOME){     // если был доход - вычитаем из счёта деньги
                $currentBill->money -= $currentTransactionMoney;
                $currentBill->update();
            }

            //редактируем новое значение счёта
            $bill = Bill::findOne($model->bill_id);
            if($model->type == Transaction::TYPE_EXPENSE){
                $bill->money -= $model->money;
                $bill->update();
            } elseif ($model->type == Transaction::TYPE_INCOME){
                $bill->money += $model->money;
                $bill->update();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'types' => $types,
            'categories' => $categories,
            'bills' => $bills
        ]);
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $bill = Bill::findOne($model->bill_id);

        $currentBill = $bill->money;
        if($model->type == Transaction::TYPE_EXPENSE){
            $bill->money += $model->money;
            $bill->update();
        } elseif ($model->type == Transaction::TYPE_INCOME){
            $bill->money -= $model->money;
            $bill->update();

        }

        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionList()
    {

        if(Yii::$app->request->isAjax)
        {
            $type = (int)Yii::$app->request->post('type');
            $categories = Category::find()
                ->where('type=:type', [':type' => $type])
                ->all();

            $option ="";
            foreach($categories as $category){
                $option .= '<option value="'.$category->id.'">'.$category->name.'</option>';
            }
        }

        return $option;
//        return $this->render('create', [
//            'parents' => $parents,
//        ]);
    }
}
