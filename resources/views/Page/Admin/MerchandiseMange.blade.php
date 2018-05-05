@extends('Page/Admin/App')

@section('title', $title)

@section('style')
    @parent
    <style>
        * {
            /*border: solid 1px;*/
        }

        #MerchandiseMange {
            width: 1000px;
            padding-left: 20px;
            padding-top: 10px;
        }
        #MerchandiseMange .productsList p {
            font-size: 15px;
            margin: 0px;
        }

        #MerchandiseMange .serachKey {
            font-size: 14px;
        }

        #MerchandiseMange .submitBtn {
            margin-top: 31px;
        }

        #MerchandiseMange .serach-group {
            padding-top: 20px;
        }

        #MerchandiseMange .groupOption {
            width: 300px;
        }

        #MerchandiseMange .nameSearchInput {
            width: 250px;
        }

        #MerchandiseMange .card-body {
            height: 75px;
            padding: 5px;
        }

        #MerchandiseMange .card{
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')

    <div id="MerchandiseMange">
        <div class="row">
            <div class="col">
                <h1>商品清單</h1>
            </div>
        </div>

        @include('Components/Error')
        <div class="form-group serach-group">
            <div class="row">
                <div class="col">
                    <label>系列搜尋:</label>
                    <select name="group" class="form-control groupOption" id="adminSearchBylistGroup">
                        <option value="1">全部</option>
                        @foreach($listGroups as $group)
                            <option value="{{$group['id']}}">{{ $group['type'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>名稱搜尋:</label>
                    <input name="nameKey" type="text" id="adminSearchNameInput" class="form-control nameSearchInput" placeholder="名稱">
                </div>
                <div class="col">
                    <label>排序:</label>
                    <select name="orderBy" class="form-control" id="adminSearchOrderBy">
                        <option value="remain_count">存貨</option>
                    </select>
                </div>
                <div class="col">
                    <button class="btn btn-primary submitBtn" @click="search()" type="submit">Search</button>
                </div>
            </div>
        </div>

        @if (!empty($products))
            <div class="row">
                @for($i = 0; $i < count($products); $i++)

                    <div class="col col-xl-3">
                        <div class="productsList">
                            <div class="card">
                                <a href="/merchandise/{{$products[$i]->id}}/edit">
                                    <img class="card-img-top card-img-size" src="{{ url($products[$i]->photos[0])}}" alt="Product">
                                </a>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col col-xl-12">
                                            <p>{{ $products[$i]->name }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-xl-12">
                                            <p> $ {{ $products[$i]->price }} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-xl-12">
                                            <p>存貨: {{ $products[$i]->remain_count }} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endfor
            </div>
            <div class="row justify-content-xl-center">
                {{ $products->appends([
                 'name' => $linkOption['name'],
                 'orderBy' => $linkOption['orderBy'],
                 'group' => $linkOption['group']])
                 ->links() }}
            </div>
        @endif
    </div>

@endsection

@section('script')
    @parent
    <script type="text/javascript">
        const MerchandiseMange = new Vue({
            el: '#MerchandiseMange',

            mounted() {

            },

            data: {
            },

            methods: {
                search: function(event) {
                    let listGroup = $("#adminSearchBylistGroup").val();
                    let nameInput = $("#adminSearchNameInput").val();
                    let orderBy = $("#adminSearchOrderBy").val();

                    let url = "/merchandise/search?group=" + listGroup + "&name=" + nameInput + "&orderBy=" + orderBy;

                    window.location = url;
                },
            },
        });
    </script>
@endsection