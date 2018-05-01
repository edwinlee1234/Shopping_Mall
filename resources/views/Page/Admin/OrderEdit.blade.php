@extends('Page/Admin/App')

@section('title', $title)

@section('style')
    @parent
    <style>
        #orderAdminEdit {
            padding-top: 10px;
            padding-left: 20px;
        }

        #orderAdminEdit .submitBtn {
            margin-top: 31px;
        }

        input[name='totalPrice'] {
            se;
        }
    </style>
@endsection

@section('content')
    <div id="orderAdminEdit">
        <div class="row">
            <div class="col">
                <h1>訂單修改</h1>
            </div>
        </div>

        @include('Components/Success')
        @include('Components/Error')
        {{ Form::open(array('url' => 'order/admin/edit/' . $orderData->id, 'method' => 'put')) }}
        {{ Form::token() }}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Full Name</label>
                @if ($errors->has('name'))
                    <input name="name" type="text" class="form-control is-invalid" placeholder=" Name" value="{{ old('name') }}">
                    <div class="invalid-feedback">
                        {{  $errors->first('name', ':message') }}
                    </div>
                @else
                    <input name="name" type="text" class="form-control" placeholder="Name" value="{{  $orderData->name  }}">
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Phone Number</label>
                @if ($errors->has('phoneNumber'))
                    <input name="phoneNumber" type="text" class="form-control is-invalid" placeholder="Phone Number" value="{{ old('phoneNumber') }}">
                    <div class="invalid-feedback">
                        {{  $errors->first('phoneNumber', ':message') }}
                    </div>
                @else
                    <input name="phoneNumber" type="text" class="form-control" placeholder="Phone Number" value="{{  $orderData->phone  }}">
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Address</label>
                @if ($errors->has('address'))
                    <input name="address" type="text" class="form-control is-invalid" placeholder="Address" value="{{ old('address') }}">
                    <div class="invalid-feedback">
                        {{  $errors->first('address', ':message') }}
                    </div>
                @else
                    <input name="address" type="text" class="form-control" placeholder="Address" value="{{ $orderData->address }}">
                @endif
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Total Price</label>
                <input name="totalPrice" type="text" class="form-control" placeholder="totalPrice" disabled="disabled" value="{{ $orderData->total_price }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Payment</label>
                <select name="payment" class="form-control">
                    @if($orderData->pay_type === "ATM")
                        <option value="ATM" selected>ATM</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Status</label>
                <select name="status" class="form-control">
                    @if($orderData->status === "N")
                        <option value="N" selected>沒付款</option>
                    @else
                        <option value="N">沒付款</option>
                    @endif

                    @if($orderData->status === "Y")
                        <option value="Y" selected>已付款</option>
                    @else
                        <option value="Y">已付款</option>
                    @endif

                    @if($orderData->status === "X")
                        <option value="X" selected>已取消</option>
                    @else
                        <option value="X">已取消</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Process</label>
                <select name="process" class="form-control">
                    @if($orderData->process === "N")
                        <option value="N" selected>待處理</option>
                    @else
                        <option value="N">待處理</option>
                    @endif

                    @if($orderData->process === "I")
                        <option value="I" selected>處理中</option>
                    @else
                        <option value="I">處理中</option>
                    @endif

                    @if($orderData->process === "D")
                        <option value="D" selected>已出貨</option>
                    @else
                        <option value="D">已出貨</option>
                    @endif
                </select>
            </div>
        </div>

        <h3>詳細訂單</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">商品名稱</th>
                <th scope="col">數量</th>
                <th scope="col">價格</th>
                <th scope="col">其他資訊</th>
                <th scope="col">總價格</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orderDetails as $orderDetail)
                <tr>
                    <td>{{ $orderDetail->name }}</td>
                    <td>{{ $orderDetail->buy_count }}</td>
                    <td>{{ $orderDetail->price }}</td>
                    @if (isset($orderDetail->extra_info['degrees']))
                        <td>{{ $orderDetail->extra_info['degrees'] }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $orderDetail->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Submit</button>
        {{ Form::close() }}
    </div>
    </div>
@endsection

@section('script')
    @parent
@endsection