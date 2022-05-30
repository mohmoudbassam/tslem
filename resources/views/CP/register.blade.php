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
            background-image: url("{{ url('/assets/img/back form.png') }}");
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
    </style>
</head>
<body class="bg-light">
<!-- start page title -->
<div class="container">
    <div class="text-center my-5">
        <a href="{{ route('public') }}">
            <img src="{{ url('/assets/img/logo-light.png') }}">
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex mt-4 justify-content-center">
                <div class="registeration-header">
                    <img src="{{ url('/assets/img/triangle-registeration.png') }}" alt="">
                    <h4 class="text-main">
                        التسجيل في البوابة
                    </h4>
                </div>


            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    <ul>

                        <li>{{session('success')  }}</li>

                    </ul>
                </div>
            @endif
            <form id="add_edit_form" method="post" action="{{route('register_action')}}" enctype="multipart/form-data">
                @csrf

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
                                       value="{{old('commercial_record')}}"
                                       id="commercial_record" placeholder="xxxxxxxxx" name="commercial_record">
                                <div class="col-12 text-danger" id="commercial_record_error"></div>
                            </div>
                        </div>
                    @endif

                    @if($record->email)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="email"> البريد الإلكتروني<span
                                        class="text-danger required-mark">*</span></label>
                                <input type="email" value="{{old('email')}}" class="form-control" id="email"
                                       name="email"
                                       placeholder="البريد الإلكتروني">
                                <div class="col-12 text-danger" id="email_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->phone)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="phone">رقم الجوال<span class="text-danger required-mark">*</span></label>
                                <input type="text" onkeypress="return /[0-9]/i.test(event.key)" value="{{old('phone')}}"
                                       class="form-control" id="phone"
                                       name="phone" minlength="10" maxlength="10"
                                       placeholder="رقم الجوال">
                                <div class="col-12 text-danger" id="phone_error"></div>
                            </div>
                        </div>
                    @endif @if(request('type') == 'service_provider')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="license_number">رقم الترخيص<span class="text-danger required-mark">*</span></label>
                                <input type="text"  value="{{old('license_number')}}"
                                       class="form-control" id="license_number"
                                       name="license_number"
                                       placeholder="رقم الترخيص">
                                <div class="col-12 text-danger" id="license_number_error"></div>
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
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name"
                                   placeholder="اسم المستخدم">
                            <div class="col-12 text-danger" id="name_error"></div>
                        </div>
                    </div>
                    <div class="row form-group">
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
                    </div>
                </div>


            </form>

            <div class="text-center mt-4">
                <button type="button" class="btn btn-lg btn-primary submit_btn mb-3">سجل الان</button>
                <br>
                <a role="button" href="{{ route('login_page') }}" class="btn">اذا كنت تمتلك حساب يرحى
                    تسجيل الدخول <span class="text-second">من هنا</span></a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

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
<script src="{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>
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

            "id_number": {
                minlength: 10,
                maxlength: 10,
                required: true
            },
            @endforeach
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
