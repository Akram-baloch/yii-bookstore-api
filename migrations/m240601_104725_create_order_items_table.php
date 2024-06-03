<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_items}}`.
 */
class m240601_104725_create_order_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-order_items-order_id}}',
            '{{%order_items}}',
            'order_id'
        );

        $this->addForeignKey(
            '{{%fk-order_items-order_id}}',
            '{{%order_items}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-order_items-book_id}}',
            '{{%order_items}}',
            'book_id'
        );

        $this->addForeignKey(
            '{{%fk-order_items-book_id}}',
            '{{%order_items}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-order_items-order_id}}',
            '{{%order_items}}'
        );

        $this->dropIndex(
            '{{%idx-order_items-order_id}}',
            '{{%order_items}}'
        );

        $this->dropForeignKey(
            '{{%fk-order_items-book_id}}',
            '{{%order_items}}'
        );

        $this->dropIndex(
            '{{%idx-order_items-book_id}}',
            '{{%order_items}}'
        );
        
        $this->dropTable('{{%order_items}}');
    }
}
