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

    public function __construct()
    {
        $this->res = [
            'result' => null,
            'data' => null,
            'errorCode' => null,
        ];
    }


    public function orderAdminMangePage()
    {
        $orderClass = Order::instance();

        $datas = array(
            'title' => 'Order mange',
            'orderDatas' => $orderClass->getAllOrder(),
        );

        return view('Page/Admin/OrderMange')->with($datas);
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
        
        // change session cart num
        $user_info = session()->get('user_info');
        $user_info['cart_num']--;
        session()->put('user_info', $user_info);

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
        $userInfo = session()->has('user_info');
        session()->put('user_info', array(
            'id' => $userInfo['id'],
            'name' => $userInfo['name'],
            'cart_num' => 0,
        ));

        return redirect()->to('/');
    }

    public function orderSearch(Request $request)
    {
        $inputs = $request->all();

        $rules = [
            'status' => 'required|in:1,N,Y,X',
        ];

        $validator = Validator::make($inputs, $rules);

        // check orderid int
        if (!empty($inputs['orderId']) && !is_int($inputs['orderId'])) {
            $error_message = array(
                'orderId' => 'The orderId must be an integer.',
            );
            return redirect()->back()->withErrors($error_message)->withInput();
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
    }
}
