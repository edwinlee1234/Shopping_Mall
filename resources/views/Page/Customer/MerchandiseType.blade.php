@extends('Page/Customer/App')

@section('title', $title)


@section('content')
    <div id="merchandiseType">
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
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            @for($i = 0; $i < count($products); $i++)

                <div class="col col-xl-3">
                    <div class="productsList">
                        <div class="card">
                            <a href="/merchandise/ {{$products[$i]->id}}">
                                <img class="card-img-top card-img-size" src="{{ url($products[$i]->photos[0])}}" alt="Product">
                            </a>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col col-xl-8">
                                        <p>{{ $products[$i]->name }}</p>
                                    </div>
                                    <div class="col col-xl-4">
                                        <p> $ {{ $products[$i]->price }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endfor
        </div>
        <div class="row justify-content-xl-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection

@section('script')
@parent
@endsection