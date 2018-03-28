<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css" type="text/css" />
    <script type="text/javascript" src="/js/app.js"></script>
    <title>@yield('title')</title>
</head>

<body>
    @include('/Components/Header')
    
    <div class="container">
        @include('/Page/Customer/LogoBar')
        
        @yield('content')
        
        @include('/Components/Footer')
    </div>
</body>
@section('script')
<script type="text/javascript">
    $document = $(document);
    
    $document.ready(function() {
        $document.on("click", '.set_language', function(event) {
            let language = this.dataset.language;

            setCookie('shopping_mall_language', language, 365);
            
            location.reload();
        });
    });
    
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
</script>
@show
</html>