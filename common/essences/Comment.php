<?php

namespace common\essences;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property int $parent_id
 * @property int $level
 * @property string $comment
 * @property string $created_at
 *
 * @property Comment $parent
 * @property Comment[] $comments
 * @property Post $post
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    public static function getMaxLevel()
    {
        $maxLevel = Comment::find()
            ->with(['user', 'post'])
            ->max('level');
        return $maxLevel;

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'comment', 'created_at'], 'required'],
            [['user_id', 'post_id', 'parent_id', 'level'], 'integer'],
            [['created_at'], 'safe'],
            [['comment'], 'string', 'max' => 256],
            [
                ['parent_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Comment::className(),
                'targetAttribute' => ['parent_id' => 'id']
            ],
            [
                ['post_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Post::className(),
                'targetAttribute' => ['post_id' => 'id']
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
            'post_id' => 'Пост',
            'parent_id' => 'В ответ на',
            'level' => 'Уровень',
            'comment' => 'Комментарий',
            'created_at' => 'Создан',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comment::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
