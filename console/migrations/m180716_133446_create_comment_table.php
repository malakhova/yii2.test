<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180716_133446_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'level' => $this->integer()->notNull()->defaultValue(0),
            'left' => $this->integer()->notNull()->defaultValue(0),
            'right' => $this->integer()->notNull()->defaultValue(0),
            'comment' => $this->string(256)->notNull(),
            'created_at' => $this->dateTime()->notNull()
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-comment-user_id',
            'comment',
            'user_id'
        );

        // creates index for column `post_id`
        $this->createIndex(
            'idx-comment-post_id',
            'comment',
            'post_id'
        );

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-comment-parent_id',
            'comment',
            'parent_id'
        );


        // add foreign key for table `comment`
        $this->addForeignKey(
            'fk-comment-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `comment`
        $this->addForeignKey(
            'fk-comment-post_id',
            'comment',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        // add foreign key for table `comment`
        $this->addForeignKey(
            'fk-comment-parent_id',
            'comment',
            'parent_id',
            'comment',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }
}
