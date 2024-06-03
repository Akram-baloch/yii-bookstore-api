<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240531_051632_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(191)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(191),
            'email' => $this->string(191)->notNull()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex('idx-users-name', '{{%users}}', 'name', true);
        $this->createIndex('idx-users-email', '{{%users}}', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
