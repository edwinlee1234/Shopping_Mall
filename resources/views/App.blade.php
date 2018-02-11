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
    
    @yield('content')

    @include('/Components/Footer')
</body>
</html>