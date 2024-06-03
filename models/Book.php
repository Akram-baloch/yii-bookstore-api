<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $author_id
 * @property int $category_id
 * @property float $price
 * @property int $number_of_pages
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'author_id', 'category_id', 'price', 'number_of_pages'], 'required'],
            [['description'], 'string'],
            [['author_id', 'category_id', 'number_of_pages'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
            'price' => 'Price',
            'number_of_pages' => 'Number Of Pages',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}