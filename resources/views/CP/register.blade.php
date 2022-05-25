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


    <link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css')}}"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300&family=Tajawal:wght@200;400&display=swap" rel="stylesheet">

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


        .fontArial{
            font-family:Tajawal;
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
                        التسجيل في المنصة
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
                            <label class="form-label" for="type">نوع المستخدم</label>
                            <select class="form-select" id="type" name="type">

                                <option @if($record->type =="service_provider") selected
                                        @endif value="service_provider">مركز، مؤسسة، شركة (مطوف)
                                </option>
                                <option @if($record->type =="design_office") selected @endif value="design_office">مكتب
                                    تصميم
                                </option>
                                <!-- <option @if($record->type =="Sharer") selected @endif value="Sharer">جهة مشاركة</option> -->
                                <option @if($record->type =="consulting_office") selected
                                        @endif  value="consulting_office">مكتب استشاري
                                </option>
                                <option @if($record->type =="contractor") selected @endif  value="contractor">مقاول
                                </option>
                                <option @if($record->type =="Delivery") selected @endif value="Delivery">تسليم</option>
                                <option @if($record->type =="Kdana") selected @endif value="Kdana">كدانة</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">اسم المستخدم</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name"
                                   placeholder="اسم المستخدم">
                            <div class="col-12 text-danger" id="name_error"></div>
                        </div>
                    </div>

                    @if($record->company_name)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company_name">اسم الشركة / المؤسسة</label>
                                <input type="text" class="form-control" id="company_name"
                                       value="{{old('company_name')}}" name="company_name"
                                       placeholder="اسم الشركة / المؤسسة">
                                <div class="col-12 text-danger" id="company_name_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->company_type)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company_type">نوع الشركة</label>
                                <select class="form-select" id="company_type" name="company_type">
                                    <option value="">اختر...</option>
                                    <option @if(old('company_type')=='organization') selected
                                            @endif value="organization">مؤسسة
                                    </option>
                                    <option @if(old('company_type')=='office') selected @endif value="office">مكتب
                                    </option>
                                </select>
                                <div class="col-12 text-danger" id="company_type_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->company_owner_name)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company_owner_name">اسم صاحب الشركة</label>
                                <input type="text" class="form-control" value="{{old('company_owner_name')}}"
                                       id="company_owner_name"
                                       name="company_owner_name" placeholder="اسم صاحب الشركة">
                                <div class="col-12 text-danger" id="company_owner_name_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->commercial_record)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="commercial_record"> رقم السجل التجاري</label>
                                <input type="number" class="form-control" value="{{old('commercial_record')}}"
                                       id="commercial_record" name="commercial_record"
                                       placeholder="رقم السجل التجاري">
                                <div class="col-12 text-danger" id="commercial_record_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->website)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="website">الموقع</label>
                                <input type="text" class="form-control" value="{{old('website')}}" id="website"
                                       name="website"
                                       placeholder="الموقع">
                                <div class="col-12 text-danger" id="website_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->responsible_name)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="responsible_name">اسم الشخص المسؤول</label>
                                <input type="text" class="form-control" value="{{old('responsible_name')}}"
                                       id="responsible_name" name="responsible_name"
                                       placeholder="اسم الشخص المسؤول">
                                <div class="col-12 text-danger" id="responsible_name_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->id_number)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="id_number">رقم الهوية</label>
                                <input type="text" class="form-control" value="{{old('id_number')}}" id="id_number"
                                       name="id_number"
                                       placeholder="رقم الهوية">
                                <div class="col-12 text-danger" id="id_number_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->id_date)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="id_date">التاريخ</label>
                                <input  type="text" class="form-control datepicker" value="{{old('id_date')}}" id="id_date"
                                       name="id_date"
                                       placeholder="التاريخ">
                                <div class="col-12 text-danger" id="id_date_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->source)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="source">المصدر</label>
                                <input type="text" class="form-control" value="{{old('source')}}" id="source"
                                       name="source" placeholder="المصدر">
                                <div class="col-12 text-danger" id="id_date_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->email)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="email">البريد الإلكتروني</label>
                                <input type="email" value="{{old('email')}}" class="form-control" id="email" name="email"
                                       placeholder="البريد الإلكتروني">
                                <div class="col-12 text-danger" id="email_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->phone)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="phone">رقم الجوال</label>
                                <input type="number" value="{{old('phone')}}" class="form-control" id="phone"
                                       name="phone" minlength="12" maxlength="12"
                                       placeholder="رقم الجوال">
                                <div class="col-12 text-danger" id="phone_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->address)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="address">العنوان الوطني</label>
                                <input type="text" class="form-control" value="{{old('address')}}" id="address"
                                       name="address"
                                       placeholder="العنوان الوطني">
                                <div class="col-12 text-danger" id="address_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->telephone)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="telephone">الهاتف</label>
                                <input type="number" value="{{old('telephone')}}" class="form-control" id="telephone"
                                       name="telephone"
                                       placeholder="الهاتف">
                                <div class="col-12 text-danger" id="telephone_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->city)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="city">المدينة</label>
                                <input type="text" value="{{old('city')}}" class="form-control" id="city" name="city"
                                       placeholder="المدينة">
                                <div class="col-12 text-danger" id="city_error"></div>
                            </div>
                        </div>
                    @endif

                   <div class="row form-group">
                       <div class="col-md-6">
                           <div class="mb-3">
                               <label class="form-label" for="password">كلمة المرور</label>
                               <input type="password" class="form-control" id="password" value="{{old('password')}}"
                                      name="password">
                               <div class="col-12 text-danger" id="password_error"></div>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="mb-3">
                               <label class="form-label" for="password_confirmation">تأكيد كلمة المرور</label>
                               <input type="password" class="form-control" value="{{old('password_confirmation')}}"
                                      id="password_confirmation"
                                      name="password_confirmation">
                               <div class="col-12 text-danger" id="password_confirmation_error"></div>
                           </div>
                       </div>
                   </div>
                    @if($record->employee_number)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="employee_number">عدد الموظفين</label>
                                <input type="number" class="form-control" value="{{old('employee_number')}}"
                                       id="employee_number" name="employee_number"
                                       placeholder="عدد الموظفين">
                                <div class="col-12 text-danger" id="employee_number_error"></div>
                            </div>
                        </div>
                    @endif
                   </div>
              </form>

            <div class="text-center mt-4">
                <button type="button" class="btn btn-lg btn-primary submit_btn">سجل الان</button>
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
<script scr="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js" ></script>
<script src="{{url("/")}}/assets/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{url("/")}}/assets/jquery-validation/dist/localization/messages_ar.min.js" type="text/javascript"></script>
<link href="{{url("/")}}/assets/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
<script src="{{url("/")}}/assets/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/bootstrap-fileinput/fileinput-theme.js" type="text/javascript"></script>
<script src = "{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>

@include('CP.layout.js')



<script>

    let old_date = "{{old('id_date')}}";
    $('input[type=text]').addClass('fontArial');
    $('input[type=number]').addClass('fontArial');
    $('input[type=email]').addClass('fontArial');


    jQuery.validator.addMethod("alphanumeric", function(value, element) {
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
        window.location = '{{route('register')}}?type=' + $(this).val()
    });

    flatpickr(".datepicker",{defaultDate: (old_date == '') ? new Date : old_date});
</script>

</body>
</html>
