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
        <div class="form-group serach-group">
            <div class="row">
                <div class="col">
                    <label>訂單狀態</label>
                    <select name="status" id="adminOrderSearchStatus" class="form-control">
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
                    <label>出貨狀態</label>
                    <select name="process" id="adminOrderSearchProcess" class="form-control">
                        <option value="1">全部</option>
                        <option value="N">待處理</option>
                        <option value="I">處理中</option>
                        <option value="D">已出貨</option>
                    </select>
                </div>
                <div class="col">
                    <label>單訂編號</label>
                    <input name="orderId" id="adminOrderSearchId" value="" type="text" class="form-control" placeholder="單訂編號">
                </div>
                <div class="col">
                    <label>排序</label>
                    <select name="orderBy" id="adminOrderSearchOrderBy"  class="form-control">
                        <option value="updated_at">更新時間</option>
                    </select>
                </div>
                <div class="col">
                    <button class="btn btn-primary submitBtn" @click="search()" type="submit">Search</button>
                </div>
            </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">單訂編號</th>
                <th scope="col">收件人名稱</th>
                <th scope="col">總金額</th>
                <th scope="col">單訂狀態</th>
                <th scope="col">出貨狀態</th>
                <th scope="col">最後更新時間</th>
                <th scope="col">功能</th>
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
                        @elseif($orderData->status === 'X')
                            已取消
                        @endif

                    </td>
                    <td>
                        @if ($orderData->process === 'N')
                            待處理
                        @elseif($orderData->process === 'I')
                            處理中
                        @elseif($orderData->process === 'D')
                            已出貨
                        @endif
                    </td>
                    <td>{{ $orderData->updated_at }}</td>
                    <td>
                        <a href="/order/admin/edit/{{ $orderData->id }}">
                            <button type="button" class="btn btn-primary btn-sm">修改</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row justify-content-xl-center">
            {{ $orderDatas->appends([
             'id' => $linkOption['id'],
             'status' => $linkOption['status'],
             'process' => $linkOption['process'],
             'orderBy' => $linkOption['orderBy']
             ])
             ->links() }}
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        const orderAdminMange = new Vue({
            el: '#orderAdminMange',

            mounted() {

            },

            data: {

            },

            methods: {
                search: function(event) {
                    let id = $("#adminOrderSearchId").val();
                    let status = $("#adminOrderSearchStatus").val();
                    let process = $("#adminOrderSearchProcess").val();
                    let orderBy = $("#adminOrderSearchOrderBy").val();

                    let url = "/order/admin/mange?id=" + id + "&status=" + status + "&process=" + process + "&orderBy=" + orderBy;

                    window.location = url;
                },
            },
        });
    </script>
@endsection