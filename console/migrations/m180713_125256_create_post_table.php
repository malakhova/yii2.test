<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180713_125256_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->notNull(),
            'content' => $this->text()->notNull(),
            'description' => $this->string(150)->notNull(),
            'created_at' => $this->dateTime()->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            'idx-post-user_id',
            'post',
            'user_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-post-user_id',
            'post',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
