@extends('CP.master')
@section('title')
انشاء موعد
@endsection
@section('content')
<link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css')}}" />
<style>
.file-preview {
    display: none;
}
</style>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء موعد</a></li>
                    <li class="breadcrumb-item"><a href="{{route('session')}}">المواعيد</a></li>
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
                    إنشاء موعد
                </h4>
            </div>

        </div>
    </div>
    <div class="card-body">
        <form id="add_edit_form" method="post" action="{{route('session.save')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="name">اسم المستخدم<span
                                class="text-danger required-mark">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name"
                            placeholder="">
                        <div class="col-12 text-danger" id="name_error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required-field" for="company_name">اسم المكتب</label>
                        <input type="text" class="form-control" id="company_name" value="{{old('company_name')}}"
                            name="company_name" placeholder="اسم المكتب">
                        <div class="col-12 text-danger" id="company_name_error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required-field" for="company_owner_name">اسم رئيس المكتب</label>
                        <input type="text" class="form-control" value="{{old('company_owner_name')}}"
                            id="company_owner_name" name="company_owner_name" placeholder="اسم رئيس المكتب">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required-field" for="email"> البريد الإلكتروني</label>
                        <input type="email" value="{{old('email')}}" class="form-control" id="email" name="email"
                            placeholder="البريد الإلكتروني">
                        <div class="col-12 text-danger" id="email_error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="box_number">رقم المربع<span
                                class="text-danger required-mark">*</span></label>
                        <select class="form-control" id="box_number" name="box_number">
                            @foreach($boxes as $box)
                                <option value="{{ $box['box'] }}">{{$box['box']}}</option>
                            @endforeach
                        </select>
                        <div class="col-12 text-danger" id="box_number_error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="camp_number">رقم المخيم<span
                                class="text-danger required-mark">*</span></label>
                        <select class="form-control" id="camp_number" name="camp_number">
                            <option value=""></option>
                        </select>
                        <div class="col-12 text-danger" id="camp_number_error"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="phone">رقم الجوال<span
                                class="text-danger required-mark">*</span></label>
                        <input type="text" onkeypress="return /[0-9]/i.test(event.key)" value="{{old('phone')}}"
                            class="form-control" id="phone" name="phone" minlength="10" maxlength="10"
                            placeholder="رقم الجوال">
                        <div class="col-12 text-danger" id="phone_error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required-field" for="password">كلمة المرور</label>
                        <input type="password" class="form-control" id="password" value="{{old('password')}}"
                            name="password">
                        <div class="col-12 text-danger" id="password_error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required-field" for="password_confirmation">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" value="{{old('password_confirmation')}}"
                            id="password_confirmation" name="password_confirmation">
                        <div class="col-12 text-danger" id="password_confirmation_error"></div>
                    </div>
                </div>

                @if($record->center_sketch)
                    <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required-field" for="center_sketch">كروكي المركز بصيغة (PDF)</label>
                                <input type="file" class="form-control" id="center_sketch"
                                    name="center_sketch" accept=".pdf">
                                <div class="col-12 text-danger" id="center_sketch_error"></div>
                            </div>
                        </div>
                @endif

                @if($record->dwg_sketch)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required-field" for="dwg_sketch">كروكي المركز بصيغة (DWG)</label>
                            <input type="file" class="form-control" id="dwg_sketch"
                                   name="dwg_sketch" accept=".dwg">
                            <div class="col-12 text-danger" id="dwg_sketch_error"></div>
                        </div>
                    </div>
                @endif

                @if($record->gis_sketch)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="gis_sketch">كروكي المركز بصيغة (GIS)</label>
                            <input type="file" class="form-control" id="gis_sketch"
                                name="gis_sketch" accept=".gis">
                            <div class="col-12 text-danger" id="gis_sketch_error"></div>
                        </div>
                    </div>
                @endif
            </div>
        </form>

        <div class="d-flex flex-wrap gap-3">
            <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء</button>
        </div>
            <br>

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

<div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
</div>

@endsection


<script src="{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>

@section('scripts')

<script>

    @foreach(array_keys(get_user_column_file($type)) as $_col)
        file_input_all('#{{$_col}}');
    @endforeach



$('#add_edit_form').validate({
        rules: {
            "name": {
                required: true,
            },
            "password": {
                required: true,
            },
            "password_confirmation": {
                required: true,
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
            "center_sketch": {
                required: true
            }
        },
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: true,
        errorPlacement: function(error, element) {
            $(element).addClass("is-invalid");
            error.appendTo('#' + $(element).attr('id') + '_error');
        },
        success: function(label, element) {

            $(element).removeClass("is-invalid");
        }
    });

    $('.submit_btn').click(function(e) {
        e.preventDefault();

        if (!$("#add_edit_form").valid())
            return false;
        $('#add_edit_form').submit()

    });

    $('#box_number').on('change', function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = '{{route('session.get_camp_by_box',':box')}}';

        url = url.replace(':box', $('#box_number').val());
        console.log(url)

        $.ajax({
            url : url,
            data: {},
            type: "GET",
            processData: false,
            contentType: false,
            beforeSend(){
                KTApp.block('#page_modal', {
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'مكتب تصميم'
                });
            },
            success:function(data) {
                if (data.success) {
                    $("#camp_number").find('option')
                        .remove();
                    $('#camp_number').html(data.page);
                }
            },
            error:function(data) {
                console.log(data);
                KTApp.unblock('#page_modal');
                KTApp.unblockPage();
            },
        });
    });
</script>

@endsection
