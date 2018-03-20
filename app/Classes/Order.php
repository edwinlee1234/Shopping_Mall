<?php
namespace App\Classes;

use App\Interfaces\OrderInterface;
use App\Model\Order as OrderModel;
use App\Model\OrderDetail as OrderDetailModel;

class Order implements OrderInterface 
{
    private static $orderClass;
    
    public static function instance()
    {
        if (self::$orderClass) {
            return self::$orderClass;
        }
        
        self::$orderClass = new self();
        
        return self::$orderClass;
    }

    public function addItem($merchandiseId, $num, $userId)
    {
        // find old
        $order = $this->checkOrderByNotPay($userId);

        // create new one
        if (count($order) <= 0) {
            $this->createOrder($userId);
            $order = $this->checkOrderByNotPay($userId);
        }

        $orderId = $order[0]['id'];

        OrderDetailModel::create(array(
            'order_id' => $orderId,
            'merchandise_id' => $merchandiseId,
            'buy_count' => $num,
        ));

        return true;
    }

    private function checkOrderByNotPay($userId)
    {
        $order = OrderModel::where('user_id', '=', $userId)->where('status', '=', 'N')->take(1)->get();

        return $order;
    }

    private function createOrder($userId)
    {
        $order = OrderModel::create(
            array(
                'user_id' => $userId
            )
        );

        return $order;
    }
    
    public function getId() 
    {
        return "getId";
    }
    
    public function getAllContent()
    {
        return "getAllContent";
    }
}