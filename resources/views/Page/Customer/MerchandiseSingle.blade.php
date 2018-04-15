@extends('Page/Customer/App')

@section('title', $title)

@section('content')
    <div id="merchandiseSingle">
        @foreach ($products as $product)
            <div class="row">
                <div class="col col-xl-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            @for ($i = 0; $i < count($types); $i++)
                                @if ($i === 0)
                                    <li class="breadcrumb-item">{{ $types[$i]['key'] }}</li>
                                @else
                                    <li class="breadcrumb-item"><a href="/merchandise/merchandiseType/{{ $types[$i]['id'] }}">{{ $types[$i]['key'] }}</a></li>
                                @endif

                            @endfor
                            <li class="breadcrumb-item">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col col-xl-7">
                    <div class="showImg">
                        <img class="img" src="{{ url($product->photos[0]) }}" alt="img">
                    </div>
                </div>

                <div class="col col-xl-5">

                    <h1 class="name">{{ $product->name }}</h1>
                    <h3 class="price">$ {{ $product->price }}</h3>

                    @if (isset($product->extra_info['degrees']) && !is_null($product->extra_info['degrees']))
                        <div class="degrees">
                            <label for="degrees">Degees:</label>
                            <br>
                            <select name="degrees" id="degrees" class="custom-select custom-select-md">
                                @foreach ($product->extra_info['degrees'] as $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="num">
                        <label for="number">Number:</label>
                        <br>
                        <select name="number" class="custom-select custom-select-md">
                            @if ($product->remain_count > 20)
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            @else
                                @for ($i = 1; $i <= $product->remain_count; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            @endif
                        </select>
                    </div>

                    <button id="addCartBtn" @click="addCart({{ $product->id }})" type="button" class="btn btn-primary">Add to Cart!</button>

                    <p>info</p>
                    <div class="info">
                        {!! $product->introduction !!}
                    </div>
                </div>

            </div>
            <div class="row justify-content-xl-center showOntherImg">
                @foreach ($product->photos as $photo)
                    <div class="col col-xl-2">
                        <img class="small-img" src="{{ url($photo) }}" alt="img">
                    </div>
                @endforeach
            </div>`
        @endforeach
    </div>
@endsection

@section('script')
@parent
<script>
    const merchandiseSingle = new Vue({
        el: '#merchandiseSingle',

        data: {
            test: 'haha',

        },

        mounted() {

        },

        methods: {
            addCart(id) {
                let self = this;

                let data = {
                    'id': id,
                    'num': $('select[name=number]').val(),
                    'degrees': $('select[name=degrees]').val(),
                };

                axios.post('/cart/api/add', data)
                    .then(function (response) {
                        if (response.data.result !== true) {
                            console.log(response.data.errorCode);

                            return;
                        }

                        let cartNumber = response.data.data.number;
                        $('#cartNum').text(cartNumber);

                        // TODO 多加一個通知成功
                        alert("Success");
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        },
    });
</script>
@endsection