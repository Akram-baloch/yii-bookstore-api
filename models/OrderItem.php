<?php

namespace app\models;
use yii\db\ActiveRecord;
class OrderItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_items';
    }
    public function rules()
    {
        return [
            [['order_id', 'book_id', 'quantity', 'price'], 'required'],
            [['order_id', 'book_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'book_id' => 'Book ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }
}
