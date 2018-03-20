<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Error as IError;
use Illuminate\Support\Facades\Input;
use App\Classes\Order;
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

    public function addItem(Request $request)
    {
        $inputs = $request->all();

        $rules = [
            'id' => 'required',
            'num' => 'required|max:20',
        ];

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $this->res['result'] = false;
            $this->res['errorCode'] = IError::DATA_FORMAT_ERROR;
            $this->res['data'] = $validator->errors();

            return $this->res;
        }

        $order = Order::instance();
        $result = $order->addItem($inputs['id'], $inputs['num'], session()->get('user_info')['id']);

        if ($result) {
            $this->res['result'] = true;

            return $this->res;
        }
    }
}
