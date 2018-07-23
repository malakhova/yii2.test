<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180704_071639_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'name' => $this->string(30)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-category-parent_id',
            'category',
            'parent_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-category-parent_id',
            'category',
            'parent_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
