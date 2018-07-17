<?php

namespace common\essences;

use Yii;
use yii\behaviors\SluggableBehavior;
use \yii\helpers\ArrayHelper;
/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $type
 * @property int $parent_id
 * @property string $name
 *
 * @property Category $parent
 * @property Category[] $categories
 */
class Category extends \yii\db\ActiveRecord
{

    const TYPE_EXPENSE = 1;
    const TYPE_INCOME = 2;

//    const PARENT_HAVE = true;
//    const PARENT_HAVENT = false;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['type', 'parent_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'parent_id' => 'Родительская категория',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return array
     * */
    public static function getTypesByValue()
    {
        return [
            self::TYPE_EXPENSE => 'Расход',
            self::TYPE_INCOME => 'Доход'
        ];
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }
    public static function getTypesByName()
    {
        return array_flip(static::getTypesByValue());
    }

//    public static function getTypeNameByValue($value, $default = null)
//    {
//        return ArrayHelper::getValue(static::getTypesByValue(), $value, $default);
//    }

    public static function getTypeValueByName($name, $default = null)
    {
        return ArrayHelper::getValue(static::getTypesByName(), $name, $default);
    }

    public static function getTypeNameByValue($type, $default = null)
    {
        $types = static::getTypesByValue();
        return isset($types[$type]) ? $types[$type] : $default;
    }

    public static function getParentList()
    {
        $parentArray = array();
        $categories = Category::find()->all();
        foreach ($categories as $category){
            if(!in_array($category->parent, $parentArray)){
                $parentArray[] = $category->parent;

            }
        }

        $list = ArrayHelper::map($parentArray, 'id', 'name');
        return $list;
    }



}
