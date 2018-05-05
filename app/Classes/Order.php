<?php
namespace App\Classes;

use DB;
use Exception;
use App\Interfaces\OrderInterface as OrderI;
use App\Model\Order as OrderModel;
use App\Model\OrderDetail as OrderDetailModel;
use App\Model\Merchandise as MerchandiseModel;

class Order implements OrderI
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

    /**
     * Add Cart Item
     * @param $merchandiseId
     * @param $num
     * @param $extra
     * @param $userId
     * @return int
     */
    public function addItem($merchandiseId, $num, $extra, $userId)
    {
        // find old
        $order = $this->checkOrderByCart($userId);

        // create new one
        if (count($order) <= 0) {
            $this->createOrder($userId);
            $order = $this->checkOrderByCart($userId);
        }

        $orderId = $order[0]['id'];

        OrderDetailModel::create(array(
            'order_id' => $orderId,
            'merchandise_id' => $merchandiseId,
            'buy_count' => $num,
            'extra_info' => json_encode($extra),
        ));

        return $this->countCartItem($orderId);
    }

    /**
     * Delete Cart Item
     * @param $id
     * @return bool
     */
    public function delItem($id)
    {
        OrderDetailModel::where('id', '=', $id)->delete();

        return true;
    }

    /**
     * 查詢購物車狀態的訂單
     * @param $userId
     * @return mixed
     */
    public function checkOrderByCart($userId)
    {
        $order = OrderModel::where('user_id', '=', $userId)->where('status', '=', OrderI::CART)->take(1)->get();

        return $order;
    }


    public function countCartItem($orderId = null, $user_id = null)
    {
        if (!is_null($orderId)) {
            return OrderDetailModel::where('order_id', '=', $orderId)
                ->count();
        }

        if (!is_null($user_id)) {
            $order = $this->checkOrderByCart($user_id);

            if (count($order) <= 0) {

                return 0;
            }

            $orderId = $order[0]['id'];

            return OrderDetailModel::where('order_id', '=', $orderId)->count();
        }
    }

    /**
     * Create Order
     * @param $userId
     * @return mixed
     */
    private function createOrder($userId)
    {
        $order = OrderModel::create(
            array(
                'user_id' => $userId
            )
        );

        return $order;
    }

    /**
     * 取得Cart的內容 (用order_id join merchandise and order_detail)
     * CartPage & checkout會到用這func
     * @param $orderId
     * @return mixed
     */
    public function getOrderDetailIncludeMerchandise($orderId)
    {
        $orderDetail = OrderDetailModel::join('merchandises', 'order_details.merchandise_id', '=', 'merchandises.id')
            ->select(
                'merchandises.id as merchandises_id',
                'merchandises.name_tw',
                'merchandises.name_cn',
                'merchandises.name_en',
                'merchandises.photos',
                'merchandises.price',
                'merchandises.remain_count',
                'order_details.id as order_detail_id',
                'order_details.extra_info',
                'order_details.buy_count'
            )
            ->where('order_details.order_id', '=', $orderId)
            ->getQuery()
            ->get();

        return $this->countTotal($orderDetail);
    }

    /**
     * 計算每一項的數量 x 價格
     * @param $orderDetails
     * @return mixed
     */
    private function countTotal($orderDetails)
    {
        // TODO 如果之後有減價活動什麼的, 就不能這樣寫了
        foreach ($orderDetails as &$orderDetail) {
            $orderDetail->total = $orderDetail->price * $orderDetail->buy_count;
        }

        return $orderDetails;
    }

    /**
     * 計算整張訂單的價格
     * @param array $orders
     * @return int
     */
    public function countOrderTotalPrice($orders)
    {
        $sum = 0;

        foreach ($orders as $order) {
            $sum += $order->total;
        }

        return $sum;
    }

    public function changeBuyCount($datas, \App\Interfaces\MerchandiseInterface $merchandiseClass)
    {
        foreach ($datas as $data) {
            $orderDetail = OrderDetailModel::find($data['id']);
            $remainCount = $merchandiseClass->checkMerchandiseRemain($orderDetail->merchandise_id);

            if ($data['buy_count'] > $remainCount) {
                return false;
            }

            $orderDetail->buy_count = $data['buy_count'];
            $orderDetail->save();
        }

        return true;
    }

    public function checkout(array $orderInput, $userId)
    {
        $orderId = $this->checkOrderByCart($userId)[0]['id'];
        $orderData = OrderModel::find($orderId);

        try {
            $orderDetails = $this->getOrderDetailIncludeMerchandise($orderId);
            // 檢查存貨夠不夠 & 更新存貨
            $result = $this->checkoutMerchandise($orderDetails);

            if ($result !== true) {
                throw new Exception("ERROR");
            }

            // count total price$orderData
            // TODO 如果之後有減價活動什麼的, 就不能這樣寫了
            $totalPrice = $this->countOrderTotalPrice($orderDetails);
            $orderData->name = $orderInput['name'];
            $orderData->address = $orderInput['address'];
            $orderData->pay_type = $orderInput['payment'];
            $orderData->phone = $orderInput['phoneNumber'];
            $orderData->status = OrderI::NOT_PAY;
            $orderData->total_price  = $totalPrice;
            $orderData->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    private function checkoutMerchandise($orderDetails)
    {
        try {
            DB::beginTransaction();

            foreach($orderDetails as $detail) {
                // lock Merchandise
                $nowMerchandise = DB::table('merchandises')->where('id', '=', $detail->merchandises_id)->sharedLock()->get()[0];

                $buyCount = $detail->buy_count;
                if ($nowMerchandise->remain_count - $buyCount < 0) {
                    throw new \Exception("存貨不足");
                }

                // update remain_count
                $afterMerchandise = MerchandiseModel::find($detail->merchandises_id);
                $afterMerchandise->remain_count = $afterMerchandise->remain_count - $buyCount;
                $afterMerchandise->save();
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

    }

    public function getAllOrderNotIncludeCart()
    {
        return OrderModel::where('status', '!=', 'C')->get();
    }

    public function searchOrder($orderId = "", $status, $process, $orderBy, $rowPerPage)
    {
        // TODO 重構這邊，多開一個搜尋用的物件
        if ($orderId != "") {
            return OrderModel::where('id', '=', $orderId)->orderBy($orderBy, 'desc')->paginate($rowPerPage);
        }

        if ($status != 1 && $process != 1) {
            return OrderModel::where('status', '=', $status)->where('process', '=', $process)->orderBy($orderBy, 'desc')->paginate($rowPerPage);
        }

        if ($status != 1) {
            return OrderModel::where('status', '=', $status)->orderBy($orderBy, 'desc')->paginate($rowPerPage);
        }

        if ($process != 1) {
            return OrderModel::where('process', '=', $process)->where('status', '!=', 'C')->orderBy($orderBy, 'desc')->paginate($rowPerPage);
        }

        return OrderModel::where('status', '!=', 'C')->orderBy($orderBy, 'desc')->paginate($rowPerPage);
    }

    public function getOrderById($orderId)
    {
        return OrderModel::find($orderId);
    }

    public function getOrderByUserId($userId, $rowPerPage)
    {
        return OrderModel::where('user_id', '=', $userId)->where('status', '!=', 'C')->orderBy('updated_at', 'desc')->paginate($rowPerPage);
    }

    /**
     * Admin更新訂單
     * @param array $input
     * @param $orderId
     * @return bool|string
     */
    public function orderUpdate(array $input, $orderId)
    {
        try {
            $order = OrderModel::find($orderId);
            $order->name = $input['name'];
            $order->phone = $input['phoneNumber'];
            $order->pay_type = $input['payment'];
            $order->status = $input['status'];
            $order->process = $input['process'];
            $order->address = $input['address'];
            $order->save();

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function cancelOrder($orderId)
    {
        try {
            $order = OrderModel::find($orderId);
            $order->status = 'X';
            $order->save();

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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