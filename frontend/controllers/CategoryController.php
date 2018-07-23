<?php

namespace frontend\controllers;

use common\essences\Category;
use frontend\forms\CategorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $types = function ($model, $key, $index, $column) {
            return $model->getTypesByValue()[$model->type];
        };

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'types' => $types,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $types = $model->getTypesByValue()[$model->type];
        if ($parent = Category::findOne($model->parent_id)) {
            $parentName = $parent->name;
        } else {
            $parentName = null;
        }
        return $this->render('view', [
            'model' => $model,
            'types' => $types,
            'parentName' => $parentName
        ]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        $types = $model->getTypesByValue();
        $parents = Category::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'parents' => $parents,
            'types' => $types,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $types = $model->getTypesByValue();
        $parents = Category::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'parents' => $parents,
            'types' => $types,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionList()
    {

        if (Yii::$app->request->isAjax) {
            $type = (int)Yii::$app->request->post('type');
            $allCategory = Category::find()
                ->where('type=:type', [':type' => $type])
                ->all();
            $treeParents = array();
            foreach ($allCategory as $category) {
                if (!$category->parent_id) {
                    $treeParents[] = $category;
                    foreach ($allCategory as $innerCategory) {
                        if ($category->id == $innerCategory->parent_id) {
                            $treeParents[] = $innerCategory;
                        }
                    }
                }
            }
            $option = "";
            foreach ($treeParents as $parent) {
                if (!$parent->parent_id) {
                    $option .= '<option value="' . $parent->id . '">' . $parent->name . '</option>';
                } else {
                    $option .= '<option value="' . $parent->id . '"> --- ' . $parent->name . '</option>';
                }
            }
        }

        return $option;
//        return $this->render('create', [
//            'parents' => $parents,
//        ]);
    }

    public function actionParentsList()
    {

        if (Yii::$app->request->isAjax) {
            $type = (int)Yii::$app->request->post('type');
            $onlyParents = Category::find()
                ->where('type=:type', [':type' => $type])
                ->andWhere(['parent_id' => null])
                ->all();

            $option = "";
            foreach ($onlyParents as $parent) {
                if (!$parent->parent_id) {
                    $option .= '<option value="' . $parent->id . '">' . $parent->name . '</option>';
                } else {
                    $option .= '<option value="' . $parent->id . '"> --- ' . $parent->name . '</option>';
                }
            }
        }

        return $option;
//        return $this->render('create', [
//            'parents' => $parents,
//        ]);
    }

}
