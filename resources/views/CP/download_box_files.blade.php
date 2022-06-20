<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta charset="utf-8"/>
    <title>تحميل الملفات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->

    <!-- plugin css -->
    <link href="{{url('/')}}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
          type="text/css"/>

    <!-- preloader css -->
    <link rel="stylesheet" href="{{url('/')}}/assets/css/preloader.min.css" type="text/css"/>

    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/assets/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{url('/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{url('/')}}/assets/css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/css/register.css" id="app-style" rel="stylesheet" type="text/css"/>

    <!-- alertifyjs default themes  Css -->
    <link href="{{url("/")}}/assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css"/>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <link href="{{url("/")}}/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet"
          type="text/css"/>

    <link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css?v=1')}}"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300&family=Tajawal:wght@200;400&display=swap"
          rel="stylesheet">

    <style>
        @font-face {
            font-family: GE-Dinar;
            src: url('{{ url('/assets/fonts/ArbFONTS-GE-Dinar-One-Medium.otf')  }}');
        }

        :root {
            --main-color: #122b76;
            --second-color: #c0946f;
        }

        body {
            font-family: GE-Dinar !important;
        }

        [dir=rtl] input {
            text-align: right;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('http://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;
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

        body {
            /* background-image: url("
        {{ url('/assets/img/back form.png') }} "); */
        }

        .text-second {
            color: var(--second-color) !important;
        }

        .text-main {
            color: var(--main-color) !important;
        }

        .file-preview {
            display: none;
        }

        .fontArial {
            font-family: Tajawal;
        }

        .alert-danger {
            color: #e9ecef;
            background-color: #db1c19;
            border-color: #e21a13;
            font-size: 16px;
            font-family: Tajawal !important;
        }

        .alert-danger ul {
            font-family: Tajawal !important;
        }

        .alert-success {
            font-size: 16px;
            font-family: Tajawal !important;
            color: #e9ecef;
            background-color: #126a47;
            border-color: #126a47;

        }

        .login {
            background-color: #FFF;
        }

        .login .alert-danger {
            color: #e9ecef;
            background-color: #b71613;
            border-color: #b71613;
        }

        .login .alert-success {
            background-color: #0b5e3d;
            border-color: #0b5e3d;
        }

        .login .form-label {
            color: #fff;
        }

        .login .form-control {
            text-align: start;
        }

        .login-body {
            background-color: var(--second-color) !important;
            padding: 30px;
        }

        .bg {
            position: relative;
            z-index: 1;
            display: inline-block;
            padding: 0px 30px;
        }

        .bg::before {
            position: absolute;
            content: "";
            z-index: -1;
            background-image: url("{{url('/')}}/assets/img/bg.png");
            background-size: auto;
            background-repeat: no-repeat;
            width: 60px;
            height: 62px;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background-position: 11px center;

        }

        .btn-blue {
            background-color: #0A2373;
            border-color: #0A2373;
            color: #FFF !important;
        }

        .bg-page-login {
            min-height: 100vh;
            background-image: url("{{url('/')}}/assets/img/bg-login.png");
            background-size: cover;
            background-repeat: no-repeat;
        }

        @media (min-width: 992px) {
            .bg-page-login {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        .bg-body {
            background-image: url("{{url('/')}}/assets/img/bg-login-body.png");
            background-size: auto;
            background-repeat: no-repeat;
            background-position: bottom right;
        }

        /* .form-label{
            color: #FFF;
        } */
    </style>
</head>

<body class="bg-light">
<!-- start page title -->
<div class="auth-page bg-page-login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-sm-9 col-lg-12 col-xl-5 col-xxl-4 mx-auto py-4">
                <form id="add_edit_form" method="post" action="{{route('register_action')}}"
                      enctype="multipart/form-data">

                    <div class="login">
                        <div class="login-header p-4">
                            <div class="mb-0">
                                <a href="{{url('/')}}" class="d-block auth-logo">
                                    <img src="{{url('/')}}/assets/img/logo2.png" alt="" width="100px"> <span
                                        class="logo-txt"></span>
                                </a>
                            </div>
                            <div class="text-center mb-1">
                                <h2 class="bg mb-0">تحميل الملفات </h2>
                            </div>
                        </div>


                        <div class="login-body bg-body p-4">
                            <div class="row" >
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <a class="btn px-5 py-1 btn-blue waves-effect waves-light" href="{{route('download_raft_company_file',['rf_id'=>$rf->id,'file_type'=>'file_first'])}}">
                                              {{$rf->file_first_name}}
                                        </a>
                                    </div>
                                </div>


                                <!-- </div> -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <div class="mb-0 ">
                                            <a class="btn px-5 py-1 btn-blue waves-effect waves-light"  href="{{route('download_raft_company_file',['rf_id'=>$rf->id,'file_type'=>'file_second'])}}"
                                            >  {{$rf->file_second_name}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-0 ">
                                        <a class="btn px-5 py-1 btn-blue waves-effect waves-light" href="{{route('download_raft_company_file',['rf_id'=>$rf->id,'file_type'=>'file_third'])}}">
                                            {{$rf->file_third_name}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end container fluid -->
</div>
<script src="{{url('/')}}/assets/libs/jquery/jquery.min.js"></script>
<script src="{{url('/')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script
    src="{{url('/')}}/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
<script scr="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script src="{{url("/")}}/assets/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{url("/")}}/assets/jquery-validation/dist/localization/messages_ar.min.js"
        type="text/javascript"></script>
<link href="{{url("/")}}/assets/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
<script src="{{url("/")}}/assets/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/bootstrap-fileinput/fileinput-theme.js" type="text/javascript"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js?v=1')}}" type="text/javascript"></script>
<script src="{{url('/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}" type="text/javascript"></script>

@include('CP.layout.js')


<script>

</script>


</body>
</html>
