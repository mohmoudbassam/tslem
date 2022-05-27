@extends('CP.master')
@section('title')
    انشاء مستخدم
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء مستخدم</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users')}}">المستخدمين</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <h4>
                        إنشاء مستخدم جديد
                    </h4>
                </div>

            </div>
        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="{{route('users.update')}}">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">الإسم</label>
                            <input type="text" disabled class="form-control" name="name" value="{{$user->name}}" id="name" placeholder="الإسم">
                            <div class="col-12 text-danger" id="name_error"></div>
                        </div>
                    </div>

                    @if($record->company_name)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company_name">اسم الشركة / المؤسسة<span
                                        class="text-danger required-mark">*</span></label>
                                <input type="text" class="form-control" id="company_name"
                                       value="{{$user->company_name}}"  name="company_name"
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
                                <input type="text" class="form-control" value="{{$user->company_owner_name}}"
                                       id="company_owner_name"
                                       name="company_owner_name" placeholder="اسم المالك">


                            </div>
                        </div>
                    @endif
                    @if($record->commercial_record)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="commercial_record"> رقم السجل التجاري</label>
                                <input type="text" onkeypress="return /[0-9]/i.test(event.key)" class="form-control"
                                       value="{{$user->commercial_record}}"
                                       id="commercial_record" name="commercial_record"
                                       placeholder="xxxxxxxxx">
                                <div class="col-12 text-danger" id="commercial_record_error"></div>
                            </div>
                        </div>
                    @endif

@if($record->id_number)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="id_number">رقم هوية المالك<span
                                        class="text-danger required-mark">*</span></label>
                                <input type="text" class="form-control" value="{{$user->id_number}}" id="id_number"
                                       name="id_number" onkeypress="return /[0-9]/i.test(event.key)" maxlength="10"
                                       placeholder="رقم الهوية">
                                <div class="col-12 text-danger" id="id_number_error"></div>
                            </div>
                        </div>
                    @endif
                    @if($record->email)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="email"> البريد الإلكتروني<span
                                        class="text-danger required-mark">*</span></label>
                                <input type="email" value="{{$user->email}}" class="form-control" id="email"
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
                                <input type="text" onkeypress="return /[0-9]/i.test(event.key)" value="{{$user->phone}}"
                                       class="form-control" id="phone"
                                       name="phone" minlength="10" maxlength="10"
                                       placeholder="رقم الجوال">
                                <div class="col-12 text-danger" id="phone_error"></div>
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
                                        <option value="{{ $cityItem }}" @if($cityItem == $user->city) selected @endif>{{ $cityItem }}</option>
                                    @endforeach
                                </select>
                                <div class="col-12 text-danger" id="city_error"></div>
                            </div>
                        </div>
                    @endif
              <input type="hidden" name="id" value="{{$user->id}}">

                </div>
            </form>

            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn">تعديل</button>
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

@endsection

@section('scripts')
    <script>

        $('#add_edit_form').validate({
            rules: {
                "name":{
                    required: true,
                },  "password":{
                    required: true,
                }, "password_confirmation_error":{
                    required: true,
                },
                @foreach(array_filter($record->makeHidden(['id','type'])->toArray()) as $rule=> $key)
                "{{"$rule"}}": {
                    required: true,
                },
                @endforeach
            },

"id_number": {
    minlength: 10,
    maxlength: 10,
    required: true
},
"commercial_record": {
    minlength: 10,
    maxlength: 10,
    required: false
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
            window.location = '{{route('users.get_form')}}?type='+$(this).val()
        });

       
    </script>

@endsection
