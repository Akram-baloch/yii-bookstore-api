<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m240530_135951_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'author_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'price' => $this->double()->notNull(),
            'number_of_pages' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk-books-author_id',
            'books',
            'author_id',
            'authors',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-books-category_id',
            'books',
            'category_id',
            'categories',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
