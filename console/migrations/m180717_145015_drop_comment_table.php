<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `comment`.
 */
class m180717_145015_drop_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('comment');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
        ]);
    }
}
