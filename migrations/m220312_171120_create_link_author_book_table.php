<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%link_author_book}}`.
 */
class m220312_171120_create_link_author_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%link_author_book}}', [
            'id' => $this->primaryKey(),
            'author' => $this->integer()->notNull(),
            'book' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%link_author_book}}');
    }
}
