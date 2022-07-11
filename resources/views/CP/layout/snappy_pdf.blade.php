<!doctype html>
<html
    lang="{{currentLocale()}}"
    dir="{{$dir}}"
>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" name="viewport">
    <title>@hasSection("title") @yield("title")@endif</title>

    <link
        href="{{ asset("assets/pdf-style/app.css") }}"
        rel="stylesheet"
        type="text/css"
    >
    <link
        href="{{ asset("assets/pdf-style/app-{$dir}.css") }}"
        rel="stylesheet"
        type="text/css"
    >
</head>
<body>
@yield('content')
</body>
</html>
