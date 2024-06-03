<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property float $total_price
 * @property string $status
 * @property string|null $order_date
 */
class Order extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'total_price', 'status'], 'required'],
            [['user_id'], 'integer'],
            [['total_price'], 'number'],
            [['order_date'], 'safe'],
            [['status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_price' => 'Total Price',
            'status' => 'Status',
            'order_date' => 'Order Date',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }
}
