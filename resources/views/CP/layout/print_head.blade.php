<!doctype html>
<html dir="{{currentLocale() === 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>

    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/assets/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <style>
        .required-field:after {
            position: relative;
            top: 3px;
            right: 6px;
            content: "*";
            color: #fd625e;
        }
        .container {
            position: fixed;
            right: 0;
            top: 0;
        }
        [dir=rtl] input {
            text-align: right;
        }
    </style>

    @yield('style')
</head>
<body>
