<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="{{currentLocale()}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>

    <link href="http://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">
    <!-- Bootstrap Css -->
    <style>
        .page-break {
            page-break-after: always;
        }
        @if(request()->has('html'))
            body {
                padding: 4em !important;
                margin: 0 !important;
                font-family: "Amiri", DejaVu Sans, sans-serif !important;
            }
        @endif
        body {
            font-size: 16px !important;
            line-height: unset !important;
        }
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
<body dir="{{request()->has('html') ? 'ltr' : (currentLocale() == 'ar' ? 'rtl' : 'ltr')}}">
