<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Error as IError;
use Illuminate\Support\Facades\Input;
use App\Classes\Order;
use App\Classes\Merchandise;
use App\Classes\User;
use App\Classes\Lang;
use Validator;

class OrderController extends Controller
{
    private $res;
    private $rowPerPage = 20;

    public function __construct()
    {
        $this->res = [
            'result' => null,
            'data' => null,
            'errorCode' => null,
        ];
    }


    public function orderAdminMangePage(Request $request)
    {
        $inputs = $request->all();
        $id = "";
        $status= 1;
        $process = 1;
        $orderBy = 'updated_at';

        if (isset($inputs['id']) && preg_match("/^[0-9]+$/", $inputs['id'])) {
            $id = $inputs['id'];
        }

        if (isset($inputs['status'])) {
            $status = $inputs['status'];
        }

        if (isset($inputs['process'])) {
            $process = $inputs['process'];
        }

        if (isset($inputs['orderBy'])) {
            $orderBy = $inputs['orderBy'];
        }

        // 這個是做分頁用的參數
        $linkOption = array(
            'id' => $id,
            'status' => $status,
            'process' => $process,
            'orderBy' => $orderBy,
        );

        $orderClass = Order::instance();
        $datas = array(
            'title' => 'Order mange',
            'orderDatas' => $orderClass->searchOrder($id, $status, $process, $orderBy, $this->rowPerPage),
            'linkOption' => $linkOption,
        );

        return view('Page/Admin/OrderMange')->with($datas);
    }

    public function orderUserMangePage()
    {
        $orderClass = Order::instance();

        $datas = array(
            'title' => 'Order mange',
            'orderDatas' => $orderClass->getOrderByUserId(session()->get('user_info')['id'], $this->rowPerPage - 5),
        );


        return view('Page/Customer/OrderMange')->with($datas);
    }

    public function checkoutPage()
    {
        $userClass = User::instance();
        $userId = $userClass->getId();
        $userData = $userClass->getAllContent($userId);

        $datas = array(
            'title' => 'Check out',
            'userInfo' => $userData,
        );

        return view('Page/Customer/Checkout')->with($datas);
    }

    public function cartPage()
    {
        $orderDetail = array();
        $orderClass = Order::instance();
        $order = $orderClass->checkOrderByCart(session()->get('user_info')['id']);


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

    public function orderEditPage(Request $request, $orderId)
    {
        $orderClass = Order::instance();
        $merchandiseClass = Merchandise::instance();
        $lang = new Lang();

        $orderDetail = $orderClass->getOrderDetailIncludeMerchandise($orderId);
        $orderDetail = $merchandiseClass->merchandiseDecode($orderDetail);
        $orderDetail = $lang->getLang($orderDetail);

        $datas = array(
            'title' => 'Order Edit',
            'orderData' => $orderClass->getOrderById($orderId),
            'orderDetails' => $orderDetail,
        );

        return view('Page/Admin/OrderEdit')->with($datas);
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
        session()->put('cart_num', $num);

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

        // change session cart num
        $cartNum = $orderClass->countCartItem(null, session()->get('user_info')['id']);
        session()->put('cart_num', $cartNum);

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

        foreach($inputs as $input) {
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

    public function checkoutProcess(Request $request)
    {
        $inputs = $request->all();

        $rules = [
            'name' => 'required',
            'phoneNumber' => 'required',
            'address' => 'required',
            'payment' => 'required',
        ];

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $orderClass = Order::instance();
        $result = $orderClass->checkout($inputs, session()->get('user_info')['id']);

        // 購買沒成功的處理
        if (!$result) {
            return redirect()->to('/cart');
        }

        // reset cart num
        session()->put('cart_num', 0);

        return redirect()->to('/');
    }

    public function orderEditProcess(Request $request, $orderId)
    {
        $inputs = $request->all();

        $rules = [
            'name' => 'required',
            'phoneNumber' => 'required',
            'address' => 'required',
            'payment' => 'required',
            'status' => 'required|in:1,N,Y,X',
            'process' => 'required|in:N,I,D',
        ];

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $orderClass = Order::instance();
        $res = $orderClass->orderUpdate($inputs, $orderId);

        if ($res === true) {
            $success_message = array(
                'success' => '更新成功',
            );

            return redirect()->back()->with($success_message);
        }
    }

    public function cancel(Request $request)
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
        $result = $orderClass->cancelOrder($inputs['id']);

        if ($result) {
            $this->res['result'] = true;

            return $this->res;
        }
    }
}
