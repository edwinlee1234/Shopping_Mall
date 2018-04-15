@extends('Page/Customer/App')

@section('title', $title)

@section('content')
    <div id="cart">
        <h1 class="title">Cart</h1>
        <div class="row">
            <div class="col col-lg-6 name">
                {{ trans('shop.order.name') }}
            </div>
            <div class="col">
                {{ trans('shop.order.info') }}
            </div>
            <div class="col">
                {{ trans('shop.order.num') }}
            </div>
            <div class="col">
                {{ trans('shop.order.remain') }}
            </div>
            <div class="col">
                {{ trans('shop.order.price') }}
            </div>
            <div class="col">
                {{ trans('shop.order.total') }}
            </div>
            <div class="col">
                {{ trans('shop.order.delete') }}
            </div>
        </div>
        <hr>
        @foreach($orders as $order)
            <div class="row">
                <div class="col col-lg-6">
                    <div class="row">
                        <div class="col col-lg-3">
                            <a href="/merchandise/ {{ $order->merchandises_id }}"><img class="cartImg" src="{{ url($order->photos[0]) }}" alt="img"></a>
                        </div>
                        <div class="col name text">
                            <p>{{ $order->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col text">
                    @if (isset($order->extra_info['degrees']) && !is_null($order->extra_info['degrees']))
                        <p>{{ $order->extra_info['degrees'] }} {{ trans('shop.order.degrees') }}</p>
                    @endif
                </div>
                <div class="col selectOption">
                    <select class="cart_select_buy_count_{{ $order->order_detail_id }} custom-select custom-select-md" @change="changeNum({{ $order->order_detail_id }})">
                        @if ($order->remain_count > 20)
                            @for ($i = 1; $i <= 20; $i++)
                                @if ($i == $order->buy_count)
                                    <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        @else
                            @for ($i = 1; $i <= $order->remain_count; $i++)
                                @if ($i == $order->buy_count)
                                    <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        @endif
                    </select>
                </div>
                <div class="col text">
                    <p>{{ $order->remain_count }}</p>
                </div>
                <div class="col text">
                    <p>{{ $order->price }}</p>
                </div>
                <div class="col text">
                    <p>{{ $order->total }}</p>
                </div>
                <div class="col text">
                    <p class="deleteBtn" @click="deleteItem({{ $order->order_detail_id }})">X</p>
                </div>
            </div>
            <br>
        @endforeach
        <hr>
        <div class="row justify-content-lg-end displayTotal">
            <div class="col col-lg-1">
                <p>Total: </p>
            </div>
            <div class="col col-lg-1">
                <p class="orderTotalPrice">{{ $totalPrice }}</p>
            </div>
        </div>
        <div class="row justify-content-lg-end">
            <div class="col col-lg-1">
                <button type="button" class="btn btn-success" @click="update">{{ trans('shop.order.update') }}</button>
            </div>
            <div class="col col-lg-1">
                <a href="">
                    <button type="button" class="btn btn-primary">{{ trans('shop.order.checkout') }}</button>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
@parent
<script>
    const Cart = new Vue({
        el: '#cart',

        data: {
            merchandises: [],
        },

        mounted() {

        },

        methods: {
            deleteItem(id) {
                let datas = {
                    'id': id,
                };

                axios.put('/cart/api/del' , datas)
                    .then(function (response) {
                        if (response.data.result !== true) {
                            console.log(response.data.errorCode);
                        }

                        location.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            update() {
                let datas = [];

                if (this.merchandises.length <= 0) {
                    return;
                }

                for (let i = 0; i < this.merchandises.length; i++) {
                    datas.push({
                        'id': this.merchandises[i],
                        'buy_count': $(".cart_select_buy_count_" + this.merchandises[i]).val(),
                    });
                }

                axios.put('/cart/api/changeBuyCount' , datas)
                    .then(function (response) {
                        if (response.data.result !== true) {
                            console.log(response.data.errorCode);

                            return;
                        }

                        location.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            changeNum(merchandisesId) {
                if (this.inArray(merchandisesId, this.merchandises)) {
                    this.merchandises.push(merchandisesId);
                }
            },

            inArray(value, array) {
                for (let i = 0; i < array.length; i++) {
                    if (array[i] === value) {
                        return false;
                    }
                }

                return true;
            }
        },
    });
</script>
@endsection