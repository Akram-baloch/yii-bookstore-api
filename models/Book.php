<?php

namespace app\models;
use yii\db\ActiveRecord;
class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'books';
    }
    public function rules()
    {
        return [
            [['name', 'author_id', 'category_id', 'price', 'number_of_pages'], 'required'],
            [['description','image'], 'string'],
            [['author_id', 'category_id', 'number_of_pages'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image', 
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
            'price' => 'Price',
            'number_of_pages' => 'Number Of Pages',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }


    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
