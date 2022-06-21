<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        content="Premium Multipurpose Admin & Dashboard Template"
        name="description"
    />
    <meta
        content="Themesbrand"
        name="author"
    />
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <!-- App favicon -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
        rel="stylesheet"
    >
    <!-- plugin css -->
    <link
        href="{{url('/')}}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
        rel="stylesheet"
        type="text/css"
    />

    <!-- preloader css -->
    <link
        rel="stylesheet"
        href="{{url('/')}}/assets/css/preloader.min.css"
        type="text/css"
    />
    <link
        rel="stylesheet"
        href="{{url('/')}}/assets/css/custom-panel.css?v={{ config('app.asset_ver') }}"
        type="text/css"
    />

    <!-- Bootstrap Css -->
    <link
        href="{{url('/')}}/assets/css/bootstrap-rtl.min.css"
        id="bootstrap-style"
        rel="stylesheet"
        type="text/css"
    />
    <!-- Icons Css -->
    <link
        href="{{url('/')}}/assets/css/icons.min.css"
        rel="stylesheet"
        type="text/css"
    />
    <!-- App Css-->
    <link
        href="{{url('/')}}/assets/css/app-rtl-3.min.css"
        id="app-style"
        rel="stylesheet"
        type="text/css"
    />
    <link
        href="{{url("/")}}/assets/bootstrap-fileinput/css/fileinput.min.css"
        rel="stylesheet"
        type="text/css"
    />
    <link
        href="{{url("/")}}/assets/libs/alertifyjs/build/css/alertify.min.css"
        rel="stylesheet"
        type="text/css"
    />

    <!-- alertifyjs default themes  Css -->
    <link
        href="{{url("/")}}/assets/libs/alertifyjs/build/css/themes/default.min.css"
        rel="stylesheet"
        type="text/css"
    />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet"
    />
    <link
        href="{{url("/")}}/assets/libs/choices.js/public/assets/styles/choices.min.css"
        rel="stylesheet"
        type="text/css"
    />

    <link
        rel="stylesheet"
        href="{{url('/assets/libs/flatpickr/flatpickr.min.css?v=1')}}"
    />
    <style>
        .required-field:after {
            position: relative;
            top: 3px;
            right: 6px;
            content: "*";
            color: #fd625e;
        }

        .modal-backdrop.show {
            display: initial !important;
        }

        .modal-backdrop.fade {
            display: initial !important;
        }

        /* @font-face {
            font-family: JannaLT;
            src: url('
        {{ url('/assets/fonts/JannaLT-Regular.woff')  }}
        ');
                } */

        /* body {
            font-family: JannaLT !important;
        } */
        .container {
            position: fixed;
            right: 0;
            top: 0;
        }

        [dir=rtl] input {
            text-align: right;
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

        .modal-header {
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
        }

        .modal-header h5 {
            color: white !important;
        }

        .modal-content {
            -webkit-box-shadow: 0 2px 8px 0 rgb(81 86 190 / 30%);
            box-shadow: 0 2px 8px 0 rgb(81 86 190 / 30%);
        }

        .alert-danger {
            color: #e9ecef;
            background-color: #db1c19;
            border-color: #e21a13;
            font-size: 16px;
            /* font-family: JannaLT !important; */
        }

        .alert-success {
            font-size: 16px;
            /* font-family: JannaLT !important; */
            color: #e9ecef;
            background-color: #126a47;
            border-color: #126a47;

        }

        .swal2-styled.swal2-confirm {
            color: #fff;
            background-color: #0A2373;
            border-color: #0A2373;
        }

        .swal2-styled.swal2-cancel {
            color: #fff;
            background-color: #fd625e;
            border-color: #fd625e;
        }

        .swal2-styled.swal2-confirm, .swal2-styled.swal2-cancel {
            /*padding: 7px 19px;*/
            /*border-radius: 2px;*/
            /*font-size: 12px;*/
            /*text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.3);*/
        }


        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .select2-container--default .select2-selection--single {
            line-height: 1.5;
            height: 40px;
            padding: 0.35rem 0.75rem;
            border-radius: 0.25rem;
            -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            color: var(--bs-body-color);
            background-color: var(--bs-input-bg);
            background-clip: padding-box;
            border: 1px solid var(--bs-input-border);
        }

        select.select2 {
            width: 100%;
            padding: 0.47rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            background-color: var(--bs-input-bg);
            background-clip: padding-box;
            border: 1px solid var(--bs-input-border);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.25rem;
            -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        }
    </style>

    @yield('style')
    @stack('css')
</head>

<body
    lang="en"
    dir="rtl"
>
