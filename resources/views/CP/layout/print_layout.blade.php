<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="{{currentLocale()}}">
<head>
    <meta charset="utf-8" content="text/html">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>

    <link href="{{public_path('assets/fonts/tajawal/stylesheet.css')}}" rel="stylesheet">
    <style type="text/css">
        html,body {
            font-family: 'Tajawal', arial, serif !important;
        }
    </style>

    <style type="text/css">
        .page-break {
            page-break-after: always;
        }
        table {
            direction: {{$dir2}};
            border-spacing: 0px;
        }
        table:not(.no-border) tbody:not(.no-border) tr:not(.no-border) td:not(.no-border) {
            border: 1px black solid;
            padding: 14px;
        }
        td {
            direction: {{$dir}};
        }
        td p{
            margin-block: 5px;
            margin-inline: 5px;
        }
    </style>

    @yield('style')
    @stack('css')
</head>
<body dir="{{$dir}}">

<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid" >
                @yield('content')
            </div>
        </div>
    </div>
</div>

@yield('scripts')
@stack('js')

</body>
</html>
