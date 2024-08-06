<?php

use yii\db\Migration;
class m240601_073706_create_orders_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'total_price' => $this->decimal(10, 2)->notNull(),
            'status' => $this->string(50)->notNull(),
            'order_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            '{{%idx-orders-user_id}}',
            '{{%orders}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-orders-user_id}}',
            '{{%orders}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-orders-user_id}}',
            '{{%orders}}'
        );

        $this->dropIndex(
            '{{%idx-orders-user_id}}',
            '{{%orders}}'
        );

        $this->dropTable('{{%orders}}');
    }
}
