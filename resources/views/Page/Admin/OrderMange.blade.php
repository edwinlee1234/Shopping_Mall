@extends('Page/Admin/App')

@section('title', $title)

@section('style')
    @parent
    <style>
        #orderAdminMange {
            padding-top: 10px;
            padding-left: 20px;
        }

        #orderAdminMange .submitBtn {
            margin-top: 31px;
        }
    </style>
@endsection

@section('content')
    <div id="orderAdminMange">
        <div class="row">
            <div class="col">
                <h1>訂單管理</h1>
            </div>
        </div>

        @include('Components/Error')
        {{ Form::open(array('url' => 'order/admin/search', 'method' => 'post')) }}
        {{ Form::token() }}
        <div class="form-group serach-group">
            <div class="row">
                <div class="col">
                    <label>訂單狀態</label>
                    <select name="status" class="form-control groupOption" id="adminSearchBylistGroup">
                        <option value="1">全部</option>
                        <option value="N">沒付款</option>
                        <option value="Y">已付款</option>
                        <option value="X">已取消</option>
                    </select>
                </div>
                {{--<div class="col">--}}
                    {{--<label>會員名稱</label>--}}
                    {{--<input name="username" type="text" id="adminSearchNameInput" class="form-control nameSearchInput" name='name' placeholder="名稱">--}}
                {{--</div>--}}
                <div class="col">
                    <label>單訂編號</label>
                    <input name="orderId" type="text" class="form-control nameSearchInput" placeholder="單訂編號">
                </div>
                <div class="col">
                    <button class="btn btn-primary submitBtn" type="submit">Search</button>
                </div>
            </div>
        </div>
        {{ Form::close() }}
        <table class="table">
            <thead>
            <tr>
                <th scope="col">單訂編號</th>
                <th scope="col">收件人名稱</th>
                <th scope="col">總金額</th>
                <th scope="col">單訂狀態</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orderDatas as $orderData)
                <tr>
                    <th>{{ $orderData->id }}</th>
                    <td>{{ $orderData->name }}</td>
                    <td>{{ $orderData->total_price }}</td>
                    <td>
                        @if ($orderData->status === 'N')
                            沒付款
                        @elseif($orderData->status === 'Y')
                            已付款
                        @else
                            已取消
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        const OrderAdminMange = new Vue({
            el: '#MerchandiseMange',

            mounted() {

            },

            data: {
                // products: [],
            },

            methods: {

            },
        });
    </script>
@endsection