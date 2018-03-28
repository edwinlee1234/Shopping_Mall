<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Error as IError;
use Illuminate\Support\Facades\Input;
use App\Classes\Order;
use App\Classes\Merchandise;
use App\Classes\Lang;
use Validator;

class OrderController extends Controller
{
    private $res;

    public function __construct()
    {
        $this->res = [
            'result' => null,
            'data' => null,
            'errorCode' => null,
        ];
    }

    public function orderListPage()
    {
        $orderClass = Order::instance();
        $order = $orderClass->checkOrderByNotPay(session()->get('user_info')['id']);

        if (count($order) <= 0) {
            $datas = array(
                'title' => 'Shopping Mall'
            );

            return view('Page/Customer/Home')->with($datas);
        }

        $lang = new Lang();
        $merchandiseClass = Merchandise::instance();

        //find order detail
        $orderDetail = $orderClass->getOrderDetailIncludeMerchandise($order[0]->id);
        $orderDetail = $merchandiseClass->merchandiseDecode($orderDetail);
        $orderDetail = $lang->getLang($orderDetail);

        $datas = array(
            'title' => 'Order',
            'orders' => $orderDetail
        );

        return view('Page/Customer/Cart')->with($datas);
    }

    public function cartPage()
    {
        $orderDetail = array();
        $orderClass = Order::instance();
        $order = $orderClass->checkOrderByNotPay(session()->get('user_info')['id']);


        // if order exist
        if (count($order) > 0) {
            $lang = new Lang();
            $merchandiseClass = Merchandise::instance();

            //find order detail
            $orderDetail = $orderClass->getOrderDetailIncludeMerchandise($order[0]->id);
            $orderDetail = $merchandiseClass->merchandiseDecode($orderDetail);
            $orderDetail = $lang->getLang($orderDetail);
        }

        $datas = array(
            'title' => 'Cart',
            'orders' => $orderDetail,
            'totalPrice' => $orderClass->countOrderTotalPrice($orderDetail),
        );

        return view('Page/Customer/Cart')->with($datas);
    }

    public function addItem(Request $request)
    {
        $inputs = $request->all();

        $rules = [
            'id' => 'required',
            'num' => 'required|max:20',
            'degrees' => 'integer',
        ];

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $this->res['result'] = false;
            $this->res['errorCode'] = IError::DATA_FORMAT_ERROR;
            $this->res['data'] = $validator->errors();

            return $this->res;
        }

        $extra = array(
            'degrees' => $inputs['degrees'],
        );

        $orderClass = Order::instance();
        $num = $orderClass->addItem($inputs['id'], $inputs['num'], $extra, session()->get('user_info')['id']);

        // change session cart num
        $user_info = session()->get('user_info');
        $user_info['cart_num'] = $num;
        session()->put('user_info', $user_info);

        if (count($num) > 0) {
            $this->res['result'] = true;
            // return cart item num
            $this->res['data']['number'] = $num;

            return $this->res;
        }
    }

    public function delItem(Request $request)
    {
        $inputs = $request->all();

        $rules = [
            'id' => 'required',
        ];

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $this->res['result'] = false;
            $this->res['errorCode'] = IError::DATA_FORMAT_ERROR;
            $this->res['data'] = $validator->errors();

            return $this->res;
        }

        $orderClass = Order::instance();
        $result = $orderClass->delItem($inputs['id']);

        if ($result) {
            $this->res['result'] = true;

            return $this->res;
        }
    }

    public function changeBuyCount(Request $request)
    {
        $inputs = $request->all();

        $rules = [
            'id' => 'required',
            'buy_count' => 'min:0'
        ];

        foreach ($inputs as $input) {
            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                $this->res['result'] = false;
                $this->res['errorCode'] = IError::DATA_FORMAT_ERROR;
                $this->res['data'] = $validator->errors();

                return $this->res;
            }
        }

        $orderClass = Order::instance();
        $merchandiseClass = Merchandise::instance();
        $result = $orderClass->changeBuyCount($inputs, $merchandiseClass);

        if ($result) {
            $this->res['result'] = true;

            return $this->res;
        }
    }

    public function checkout()
    {

    }
}
