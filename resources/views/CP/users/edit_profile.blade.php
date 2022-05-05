@extends('CP.master')
@section('title')
    الملف الشخصي
    @endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">إضافة مستخدم</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('users')}}">المستخدمين</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="card-body p-4">

            <div class="row">
                <form id="add_edit_form" method="post" action="{{route('save_profile')}}" enctype="multipart/form-data">
                    @csrf


                    <div class="col-lg-12">
                        <div>

                            <div class="mb-3">
                                <label for="name" class="form-label">اسم المستخدم</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{auth()->user()->name}}" disabled>
                                <div class="col-12 text-danger" id="name_error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input class="form-control" type="text" id="email" value="{{auth()->user()->email}}" name="email">
                                <div class="col-12 text-danger" id="email_error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">الهاتف</label>
                                <input class="form-control" type="number" id="phone" value="{{auth()->user()->phone}}" name="phone">
                                <div class="col-12 text-danger" id="phone_error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input class="form-control" type="password" name="password" id="password">
                                <div class="col-12 text-danger" id="password_error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation " class="form-label">تأكيد كلمة المرور</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                                <div class="col-12 text-danger" id="confirmed_password_error"></div>
                            </div>


                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-lg btn-primary submit_btn">تعديل  </button>
                    </div>
                </form>
                <br>
                <br>

            </div>


        </div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <li>{{ $error }}</li>
                </div>
            @endforeach
        @endif
        @if (session('success'))

            <div class="alert alert-success" role="alert">
                <li>{{ session('success') }}</li>
            </div>

        @endif
    </div>


@endsection
@section('scripts')

    <script>
        @if(auth()->user()->image)
        file_input('#image', {
            initialPreview: '{{auth()->user()->image}}',
        });
        @else
        file_input('#image');
        @endif
        $('#add_edit_form').validate({
            rules: {


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
    </script>
@endsection
