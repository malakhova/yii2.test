<?php

namespace common\essences;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property int $category_id
 * @property int $bill_id
 * @property string $money
 * @property string $created_at
 *
 * @property Bill $bill
 * @property Category $category
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{

    const TYPE_EXPENSE = 1;
    const TYPE_INCOME = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    public static function getTypesByValue()
    {
        return [
            self::TYPE_EXPENSE => 'Расход',
            self::TYPE_INCOME => 'Доход'
        ];
    }

    public static function getCategoryList()
    {
        $categoryArray = array();
        $categories = Category::find()->all();
        foreach ($categories as $category) {
            if (!in_array($category, $categoryArray)) {
                $categoryArray[] = $category;

            }
        }

        $list = ArrayHelper::map($categoryArray, 'id', 'name');
        return $list;
    }

    public static function getBillList()
    {
        $billArray = array();
        $bills = Bill::find()->all();
        foreach ($bills as $bill) {
            if (!in_array($bill, $billArray)) {
                $billArray[] = $bill;

            }
        }

        $list = ArrayHelper::map($billArray, 'id', 'name');
        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'category_id', 'bill_id', 'money', 'created_at'], 'required'],
            [['user_id', 'type', 'category_id', 'bill_id'], 'integer'],
            [['money'], 'number'],
            [['created_at'], 'safe'],
            [
                ['bill_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Bill::className(),
                'targetAttribute' => ['bill_id' => 'id']
            ],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'type' => 'Тип',
            'category_id' => 'Категория',
            'bill_id' => 'Счёт',
            'money' => 'Сумма',
            'created_at' => 'Дата/время',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
