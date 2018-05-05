@extends('Page/Customer/App')

@section('title', $title)

@section('content')
    <div id="OrderUserMange">
        <h1>訂單查詢</h1>
        @if (count($orderDatas) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">單訂編號</th>
                    <th scope="col">收件人名稱</th>
                    <th scope="col">總金額</th>
                    <th scope="col">訂單狀態</th>
                    <th scope="col">出貨狀態</th>
                    {{-- TODO 訂單的修改頁面--}}
                    {{--<th scope="col">功能</th>--}}
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
                        <td>
                            @if ($orderData->process === 'N')
                                待處理
                            @elseif($orderData->process === 'I')
                                處理中
                            @else
                                已出貨
                            @endif

                        </td>
                        {{--<td>--}}
                        {{--@if($orderData->process === 'I' || $orderData->process === 'D')--}}
                        {{--<button type="button" @click="cancel({{ $orderData->id }})" disabled class="btn btn-danger btn-sm">取消</button>--}}
                        {{--@else--}}
                        {{--<button type="button" @click="cancel({{ $orderData->id }})" class="btn btn-danger btn-sm">取消</button>--}}
                        {{--@endif--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row justify-content-xl-center">
                {{ $orderDatas->links() }}
            </div>
        @else
            <h1>沒有訂單</h1>
        @endif
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        const OrderUserMange = new Vue({
            el: '#OrderUserMange',

            mounted() {

            },

            data: {

            },

            methods: {
                // cancel(orderId) {
                //     // api
                //     let datas = {
                //         'id': orderId,
                //     };
                //
                //     axios.put('/order/api/cancel' , datas)
                //         .then(function (response) {
                //             if (response.data.result !== true) {
                //                 console.log(response.data.data);
                //                 return;
                //             }
                //
                //             location.reload();
                //         })
                //         .catch(function (error) {
                //             console.log(error);
                //         });
                // },
            },
        });
    </script>
@endsection