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
      font-size: 10px;
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
      height: 50px;
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
    {{ Form::open(array('url' => 'merchandise/search', 'method' => 'post')) }}
    {{ Form::token() }}
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
                <input name="nameKey" type="text" id="adminSearchNameInput" class="form-control nameSearchInput" name='name' placeholder="名稱">
            </div>
            <div class="col">
                <label>排序:</label>
                <select name="orderBy" class="form-control" id="adminSearchOrderBy">
                    <option value="remain_count">存貨</option>
                </select>
            </div>
            <div class="col">
                <button class="btn btn-primary submitBtn" type="submit">Search</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}  
    
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
        <div class="col col-xl-2 pageLink">
            {{ $products->links() }}
        </div>
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
            // products: [],
        },
        
        methods: {
            // search: function(event) {
            //     let listGroup = $("#adminSearchBylistGroup").val();
            //     let nameInput = $("#adminSearchNameInput").val();
            //     let orderBy = $("#adminSearchOrderBy").val();

            //     if (listGroup == -1 && nameInput == "") {
            //         alert("搜尋條件不可空白");
                      
            //         return;
            //     }
                  
            //     let condition = {
            //         orderBy: orderBy,
            //         listGroup: listGroup,
            //         nameInput: nameInput,
            //     };
                  
            //     axios.post('/merchandise/api/search', condition)
            //     .then(function (response) {
            //         console.log(response);
            //         if (response.data.result !== true) {
            //             console.log(response.data.errorCode);
                        
            //             return;
            //         }
            //         console.log(response.data.data);
            //         self.products = response.data.data;
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     }); 
            // },
        },
    });
</script>
@endsection