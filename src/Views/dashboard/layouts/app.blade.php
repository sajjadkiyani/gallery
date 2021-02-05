<!doctype html>
<html lang="fa" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('gallery::dashboard.inc.head_links')
    @yield('head')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    @include('gallery::dashboard.inc.script_main')
    @yield('script')
</body>
</html>
