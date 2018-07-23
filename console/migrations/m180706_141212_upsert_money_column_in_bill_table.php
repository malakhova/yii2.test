<?php

use yii\db\Migration;

/**
 * Class m180706_141212_upsert_money_column_in_bill_table
 */
class m180706_141212_upsert_money_column_in_bill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $this->upsert('bill',['money' => $this->decimal()->defaultValue(0.00)], true);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180706_141212_upsert_money_column_in_bill_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180706_141212_upsert_money_column_in_bill_table cannot be reverted.\n";

        return false;
    }
    */
}
