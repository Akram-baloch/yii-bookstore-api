<?php

namespace app\controllers\api;

use Yii;
use app\models\Order;
use yii\filters\Cors;
use yii\web\Response;
use yii\rest\Controller;
use app\models\OrderItem;

class OrderController extends Controller
{
    public $modelClass = 'app\models\order';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:4200'],
                'Access-Control-Request-Method' => ['POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $listOrder = Order::find()->all();
        return ['status' => 'success', 'data' => $listOrder];
    }


    public function actionCheckout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cartData = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $order = new Order();
            $order->user_id = $cartData['user_id'];
            $order->total_price = array_reduce($cartData['order_items'], function ($sum, $item) {
                return $sum + ($item['quantity'] * $item['price']);
            }, 0);
            $order->status = 'pending';
            $order->order_date = date('Y-m-d H:i:s');

            if ($order->save()) {
                foreach ($cartData['order_items'] as $itemData) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->book_id = $itemData['book_id'];
                    $orderItem->quantity = $itemData['quantity'];
                    $orderItem->price = $itemData['price'];

                    if (!$orderItem->save()) {
                        $transaction->rollBack();
                        return ['status' => 'error', 'message' => 'Failed to save order items'];
                    }
                }
                $transaction->commit();
                return ['status' => 'success', 'data' => $order];
            } else {
                $transaction->rollBack();
                return ['status' => 'error', 'message' => 'Failed to save order'];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
