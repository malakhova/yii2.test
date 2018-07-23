<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bill`.
 */
class m180704_134704_create_bill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bill', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(30)->notNull()->defaultValue("Наличные"),
            'money' => $this->decimal()->notNull()->defaultValue(0),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            'idx-bill-user_id',
            'bill',
            'user_id'
        );

        // add foreign key for table `bill`
        $this->addForeignKey(
            'fk-bill-user_id',
            'bill',
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
        $this->dropTable('bill');
    }
}
