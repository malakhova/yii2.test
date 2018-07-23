<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction`.
 */
class m180706_134504_create_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'bill_id' => $this->integer()->notNull(),
            'money' => $this->decimal()->notNull(),
            'created_at' => $this->dateTime()->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            'idx-transaction-user_id',
            'transaction',
            'user_id'
        );

        // add foreign key for table `transaction`
        $this->addForeignKey(
            'fk-transaction-user_id',
            'transaction',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-transaction-category_id',
            'transaction',
            'category_id'
        );

        // add foreign key for table `transaction`
        $this->addForeignKey(
            'fk-transaction-category_id',
            'transaction',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        // creates index for column `bill_id`
        $this->createIndex(
            'idx-transaction-bill_id',
            'transaction',
            'bill_id'
        );

        // add foreign key for table `transaction`
        $this->addForeignKey(
            'fk-transaction-bill_id',
            'transaction',
            'bill_id',
            'bill',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transaction');
    }
}
