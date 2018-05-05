@extends('Page/Customer/App')

@section('title', $title)

@section('content')
    <div id="Center">
        <div class="row">
            <div class="col col-xl-12">
                <h1>Center</h1>
            </div>
        </div>
        <div class="row">
                <div class="col col-xl-12 userBox">
                    <a href="/user/edit">
                        <h1>修改會員資料</h1>
                    </a>
                </div>

                <div class="col col-xl-12 orderBox">
                    <a href="/order/mange">
                        <h1>查詢訂單</h1>
                    </a>
                </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
@endsection