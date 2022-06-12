<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta charset="utf-8"/>
    <title>تسجيل</title>
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
    <link href="{{url("/")}}/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css')}}"/>
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
            /* background-image: url("{{ url('/assets/img/back form.png') }}"); */
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
        .alert-danger{
            color: #e9ecef;
            background-color: #db1c19;
            border-color: #e21a13;
            font-size: 16px;
            font-family: Tajawal !important;
        }

        .alert-danger ul{
            font-family: Tajawal !important;
        }

        .alert-success{
            font-size: 16px;
            font-family: Tajawal !important;
            color: #e9ecef;
            background-color: #126a47;
            border-color: #126a47;

        }
        .login{
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
            .login .form-label{
                color: #fff;
            }
            .login .form-control{
                text-align: start;
            }
            .login-body{
                background-color: var(--second-color) !important;
                padding: 30px;
            }
            .bg{
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
            .bg-page-login{
                min-height: 100vh;
                background-image: url("{{url('/')}}/assets/img/bg-login.png");
                background-size: cover;
                background-repeat: no-repeat;
            }
            @media(min-width:992px){
                .bg-page-login{
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            }
            .bg-body{
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
            <div class="col-md-7 col-sm-9 col-lg-6 col-xl-5 col-xxl-4 mx-auto py-4">
                <form id="add_edit_form" method="post" action="{{route('register_action')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="login">
                        <div class="login-header p-4">
                            <div class="mb-0">
                                <a href="{{url('/')}}" class="d-block auth-logo">
                                    <img src="{{url('/')}}/assets/img/logo2.png" alt=""  width="100px"> <span class="logo-txt"></span>
                                </a>
                            </div>
                            <div class="text-center mb-1">
                                <h2 class="bg mb-0">التسجيل في البوابة</h2>
                            </div>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                <ul>

                                    <li>{{session('success')  }}</li>

                                </ul>
                            </div>
                        @endif
                        <div class="login-body bg-body p-4">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="type">نوع المستخدم<span
                                                class="text-danger required-mark">*</span></label>
                                        <select class="form-select" id="type" name="type">

                                            <option @if($record->type =="service_provider") selected
                                                    @endif value="service_provider">شركات حجاج الداخل
                                            </option>
                                            <option @if($record->type =="design_office") selected @endif value="design_office">مكتب
                                                هندسي
                                            </option>
                                        <!-- <option @if($record->type =="Sharer") selected @endif value="Sharer">جهة مشاركة</option> -->

                                            <option @if($record->type =="contractor") selected @endif  value="contractor">مقاول
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                @if($has_designer_type)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="designer_multiple_type">التخصص<span
                                                    class="text-danger required-mark">*</span></label>
                                            <select class="form-select" multiple id="designer_multiple_type" name="designer_multiple_type[]">

                                                <option
                                                        value="designer">مكتب تصميم
                                                </option>
                                                <option   value="consulting">اشراف
                                                </option>
                                                <option
                                                        value="fire">الحماية والوقاية من الحريق
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                @endif


                                @if($record->type=='contractor')
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="designer_type">التخصصات<span
                                                    class="text-danger required-mark">*</span></label>
                                            <select class="form-control"  id="designer_type" name="designer_type">
                                                @foreach($contractor_types as $type)
                                                <option   value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if($record->company_name)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="company_name">اسم الشركة / المؤسسة<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="text" class="form-control" id="company_name"
                                                value="{{old('company_name')}}"  name="company_name"
                                                placeholder="اسم الشركة / المؤسسة">
                                            <div class="col-12 text-danger" id="company_name_error"></div>
                                        </div>
                                    </div>
                                @endif
                                @if($record->company_owner_name)
                                    <div class="col-md-6">
                                        <div class="mb-3">

                                            <label class="form-label" for="company_owner_name">اسم المالك<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="text" class="form-control" value="{{old('company_owner_name')}}"
                                                id="company_owner_name"
                                                name="company_owner_name" placeholder="اسم المالك">
                                            <div class="col-12 text-danger" id="company_owner_name_error"></div>
                                        </div>
                                    </div>
                                @endif
                                @if($record->id_number)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="id_number">رقم هوية المالك<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="text" class="form-control" value="{{old('id_number')}}" id="id_number"
                                                name="id_number" onkeypress="return /[0-9]/i.test(event.key)" maxlength="10"
                                                placeholder="رقم الهوية">
                                            <div class="col-12 text-danger" id="id_number_error"></div>
                                        </div>
                                    </div>
                                @endif
                                @if($record->commercial_record)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="commercial_record"> رقم السجل التجاري <span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="text" class="form-control"
                                                   onkeypress="return /[0-9]/i.test(event.key)"                                                value="{{old('commercial_record')}}"
                                                id="commercial_record" placeholder="xxxxxxxxx" name="commercial_record" minlength="10" maxlength="10">
                                            <div class="col-12 text-danger" id="commercial_record_error"></div>
                                        </div>
                                    </div>
                                @endif

                                @if($record->email)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="email"> البريد الإلكتروني<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email"
                                                placeholder="البريد الإلكتروني">
                                            <div class="col-12 text-danger" id="email_error">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($record->phone)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="phone">رقم الجوال<span class="text-danger required-mark">*</span></label>
                                            <input type="text" onkeypress="return /[0-9]/i.test(event.key)" value="{{old('phone')}}"
                                                class="form-control @error('email') is-invalid @enderror" id="phone"
                                                name="phone" minlength="10" maxlength="10"
                                                placeholder="رقم الجوال">
                                            <div class="col-12 text-danger" id="phone_error">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif @if($record->license_number)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="license_number">رقم الترخيص<span class="text-danger required-mark">*</span></label>
                                            <input type="text"  value="{{old('license_number')}}"
                                                class="form-control @error('license_number') is-invalid @enderror" id="license_number"
                                                name="license_number"
                                                placeholder="رقم الترخيص">
                                            <div class="col-12 text-danger" id="license_number_error">
                                                @error('license_number')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($record->box_number)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="box_number">رقم المربع<span class="text-danger required-mark">*</span></label>
                                            <input type="text"  value="{{old('box_number')}}"
                                                class="form-control" id="box_number"
                                                name="box_number"
                                                placeholder="رقم المربع">
                                            <div class="col-12 text-danger" id="box_number_error"></div>
                                        </div>
                                    </div>
                                @endif
                                @if($record->camp_number)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="camp_number">رقم المخيم<span class="text-danger required-mark">*</span></label>
                                            <input type="text"  value="{{old('camp_number')}}"
                                                class="form-control" id="رقم المخيم"
                                                name="camp number"
                                                placeholder="رقم المخيم">
                                            <div class="col-12 text-danger" id="camp_number_error"></div>
                                        </div>
                                    </div>
                                @endif
                                @if($record->city)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="city">المدينة<span
                                                    class="text-danger required-mark">*</span></label>
                                            <select class="form-control" id="city" name="city">
                                                @foreach(citiesList() as $cityItem)
                                                    <option value="{{ $cityItem }}" @if($cityItem == $record->city || $cityItem == old('city')) selected @endif>{{ $cityItem }}</option>
                                                @endforeach
                                            </select>
                                            <div class="col-12 text-danger" id="city_error"></div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">اسم المستخدم<span
                                                class="text-danger required-mark">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" id="name"
                                            placeholder="اسم المستخدم">
                                        <div class="col-12 text-danger" id="name_error">
                                            @error('name')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row form-group"> -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="password">كلمة المرور<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="password" class="form-control" id="password" value="{{old('password')}}"
                                                name="password">
                                            <div class="col-12 text-danger" id="password_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="password_confirmation">تأكيد كلمة المرور<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="password" class="form-control" value="{{old('password_confirmation')}}"
                                                id="password_confirmation"
                                                name="password_confirmation">
                                            <div class="col-12 text-danger" id="password_confirmation_error"></div>
                                        </div>
                                    </div>
                                <!-- </div> -->
                                <!-- <div class="row"> -->
                                    <div class="mb-3">
                                        <div class="mb-0 text-end">
                                            <button class="btn px-5 py-1 btn-blue waves-effect waves-light" type="submit">سجل الان</button>
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="login-footer py-3 px-4">
                            <div class="text-end mb-3">
                                <a href="{{ route('login_page') }}" class="btn px-2 py-1 btn-secondary shadow-none">تسجيل الدخول</a>
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
<script src="{{url('/assets/libs/flatpickr/flatpickr.min.js?v=1')}}" type="text/javascript"></script>
<script src="{{url('/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}" type="text/javascript"></script>

@include('CP.layout.js')


<script>
    $(function(){
        new Choices("#designer_multiple_type", {removeItemButton: !0})
    });

    let old_date = "{{old('id_date')}}";
    $('input[type=text]').addClass('fontArial');
    $('input[type=number]').addClass('fontArial');
    $('input[type=email]').addClass('fontArial');
    jQuery.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || /^\w+$/i.test(value);
    }, "يرجى ادخال حروف  أو أرقام او علامة _ ");
    $('#add_edit_form').validate({
        lang: 'ar',
        rules: {
            "name": {
                required: true,
                alphanumeric: true
            }, "password": {
                required: true,
            }, "password_confirmation": {
                required: true,
            },
            @foreach(array_filter($record->makeHidden(['id','type'])->toArray()) as $rule=> $key)
                "{{"$rule"}}": {
                    required: true,
                },
            @endforeach
            "id_number": {
                minlength: 10,
                maxlength: 10,
                required: true
            },
            "commercial_record": {
                minlength: 10,
                maxlength: 10,
                required: true,
                number: true
            },
        },
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: true,
        errorPlacement: function (error, element) {
            $(element).addClass("is-invalid");
            error.appendTo('#' + $(element).attr('id') + '_error');
        },
        success: function (label, element) {
            $(element).removeClass("is-invalid");
        }
    });
    $('.submit_btn').click(function (e) {
        e.preventDefault();
        if (!$("#add_edit_form").valid())
            return false;
        $('#add_edit_form').submit()
    });
    $('#type').change(function (e) {
        window.location = '{{route('register')}}/' + $(this).val()
    });
    {{--$('#designer_type').change(function (e) {--}}
    {{--    window.location = '{{route('register')}}/' + '{{request('type')}}' +'/'+'{{request('designer_type')}}'+$(this).val()--}}
    {{--});--}}
    flatpickr(".datepicker", {defaultDate: (old_date == '') ? new Date : old_date});
</script>

</body>
</html>
