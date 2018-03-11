<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css" type="text/css" />
    <link rel="stylesheet" href="/css/sidebar.css" type="text/css" />
    <title>@yield('title')</title>
</head>
@section('style')
<style type="text/css">
    * {
        font-family: 微軟正黑體;
    }
    
    .content {
        margin-left: 250px;
    }
    
    html, body{
        padding: 0px;
        margin: 0px;
    }
    
    .container-fluid{
        padding: 0px;
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
<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
<script type="text/javascript" src="/js/app.js"></script>
@show
</html>