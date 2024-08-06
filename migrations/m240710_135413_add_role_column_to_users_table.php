<?php

use yii\db\Migration;
class m240710_135413_add_role_column_to_users_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'role', "ENUM('user', 'admin') NOT NULL DEFAULT 'user'");
    }
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'role');
    }
}
