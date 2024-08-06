<?php

use yii\db\Migration;
class m240607_063637_add_image_column_to_books_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%books}}', 'image', $this->string()->after('description'));
    }
    public function safeDown()
    {
        $this->dropColumn('{{%books}}', 'image');
    }
}
