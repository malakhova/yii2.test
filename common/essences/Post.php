<?php

namespace common\essences;

use common\essences\User;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $description
 * @property string $created_at
 *
 * @property User $user
 */
class Post extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
            ],
//            [
//                'class' => TimestampBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
////                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
//                ],
//                // если вместо метки времени UNIX используется datetime:
//                'value' => new Expression('NOW()'),
//            ],
//            'timestamp' => [
//                'class' => TimestampBehavior::className(),
//                'attributes' =>
//                    [
//                        ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
////                        ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time'
//                    ],
//                'value' => new Expression('NOW()')
//            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'slug', 'content', 'description', 'created_at'], 'required'],
            [['user_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 150],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'title' => 'Заголовок',
            'slug' => 'Slug',
            'content' => 'Контент',
            'description' => 'Описание',
            'created_at' => 'Создано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
