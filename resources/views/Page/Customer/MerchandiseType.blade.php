@extends('Page/Customer/App')

@section('title', $title)

@section('style')
@parent
<style type="text/css">
.card-img-size {
  width: 100%;
  height: 150px;
}
</style>
@endsection

@section('content')
    <div class="row">
    @for($i = 0; $i < count($products); $i++)
    
      <div class="col-md-3">
        <div class="productsList">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top card-img-size" src="{{ url($products[$i]->photos[0])}}" alt="Card image cap">
            <div class="card-body">
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>   
      </div>
    

    @endfor
    </div>
@endsection

@section('script')
@parent
@endsection