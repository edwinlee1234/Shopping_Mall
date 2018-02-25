<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css" type="text/css" />
    <script type="text/javascript" src="/js/app.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('/css/sideBar.css') }}" type="text/css" />
    <title>@yield('title')</title>
</head>
@section('style')
<style type="text/css">
    * {
        font-family: 微軟正黑體;
    }
    
    .menu, .content {
        vertical-align: top;
        display: inline-block;
    }
</style>
@show
<body>
    <div class="container-fluid">
        <div class="menu">
            @include('/Components/SideBar')
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
@section('script')

@show
</html>