<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->

    <!-- plugin css -->
    <link href="{{url('/')}}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{url('/')}}/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/assets/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{url('/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{url('/')}}/assets/css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{url("/")}}/assets/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />

    <!-- alertifyjs default themes  Css -->
    <link href="{{url("/")}}/assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    @yield('style')
    <style>
        @font-face {
            font-family: GE-Dinar;
            src: url('{{ url('/assets/fonts/ArbFONTS-GE-Dinar-One-Medium.otf')  }}');
        }

        body {
            font-family: GE-Dinar !important;
        }

         [dir=rtl] input {
             text-align: right;
         }
         .modal {
             display:    none;
             position:   fixed;
             z-index:    1000;
             top:        0;
             left:       0;
             height:     100%;
             width:      100%;
             background: rgba( 255, 255, 255, .8 )
             url('http://i.stack.imgur.com/FhHRx.gif')
             50% 50%
             no-repeat;
         }

         /* When the body has the loading class, we turn
            the scrollbar off with overflow:hidden */
         body.loading .modal {
             overflow: hidden;
         }

         /* Anytime the body has the loading class, our
            modal element will be visible */
         body.loading .modal {
             display: block;
         }
     </style>
</head>

<body lang="en" dir="rtl">
