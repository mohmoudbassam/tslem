@extends('CP.master')
@section('title')
تفعيل الحساب
@endsection
@section('content')
<link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css')}}"/>
<style>
.file-preview {
    display: none;
}
</style>
<div class="row">
    <alert class="alert alert-danger" style="font-size:20px;">استكمل رفع الملفات لاعتماد تسجيلك والاطلاع عليه</alert>
</div>

<div class="card">
    <div class="card-header">
        <div class="row mt-4">
            <div class="col-lg-12">
                <h3>رفع الملفات</h3>
            </div>


        </div>
    </div>
    <div class="card-body">

        <form id="add_edit_form" method="post" action="{{route('upload_files_action')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">



                @if($record->commercial_file)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="commercial_file">السجل التحاري (PDF)</label>
                            <input type="file" class="form-control" value="{{old('commercial_file')}}"
                                id="commercial_file" name="commercial_file">
                            <div class="col-12 text-danger" id="commercial_file_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="commercial_file_end_date">تاريخ انتهاء السجل التجاري</label>
                            <input type="text" class="form-control datepicker"
                                value="{{old('commercial_file_end_date')}}" id="commercial_end_date"
                                name="commercial_file_end_date">
                            <div class="col-12 text-danger" id="commercial_file_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->rating_certificate)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="rating_certificate">شهادة تصنيف بلدي (PDF)</label>
                            <input type="file" class="form-control" id="rating_certificate" name="rating_certificate">
                            <div class="col-12 text-danger" id="rating_certificate_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="rating_certificate_end_date">تاريخ الانتهاء</label>
                            <input type="text" class="form-control datepicker" id="rating_certificate_end_date"
                                name="rating_certificate_end_date">
                            <div class="col-12 text-danger" id="rating_certificate_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->address_file)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="address_file">العنوان الوطني (PDF)</label>
                            <input type="file" class="form-control" name="address_file" id="address_file">
                            <div class="col-12 text-danger" id="address_file_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->profession_license)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="profession_license">شهادة مزاولة المهنة (PDF)</label>
                            <input type="file" class="form-control" id="profession_license" name="profession_license">
                            <div class="col-12 text-danger" id="profession_license_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="profession_license_end_date">تاريخ الانتهاء</label>
                            <input type="text" class="form-control datepicker" id="profession_license_end_date"
                                name="profession_license_end_date">
                            <div class="col-12 text-danger" id="profession_license_date_end_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->business_license_end_date)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="business_license">رخصة نشاط تجاري (PDF)</label>
                            <input type="file" class="form-control" name="business_license" id="business_license">
                            <div class="col-12 text-danger" id="business_license_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="business_license_end_date">تاريخ الانتهاء</label>
                            <input type="text" class="form-control datepicker" id="business_license_end_date"
                                name="business_license_end_date">
                            <div class="col-12 text-danger" id="business_license_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
{{--                @if($record->social_insurance_certificate)--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="social_insurance_certificate">رخصة التأمينات--}}
{{--                                الإجتماعية (PDF)</label>--}}
{{--                            <input type="file" class="form-control" id="social_insurance_certificate"--}}
{{--                                name="social_insurance_certificate">--}}
{{--                            <div class="col-12 text-danger" id="social_insurance_certificate_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="social_insurance_certificate_end_date">تاريخ--}}
{{--                                الانتهاء</label>--}}
{{--                            <input type="text" class="form-control datepicker"--}}
{{--                                id="social_insurance_certificate_end_date" name="social_insurance_certificate_end_date">--}}
{{--                            <div class="col-12 text-danger" id="social_insurance_certificate_end_date_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
{{--                @if($record->certificate_of_zakat)--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="certificate_of_zakat">رخصة الزكاة والدخل (PDF)</label>--}}
{{--                            <input type="file" class="form-control" id="certificate_of_zakat"--}}
{{--                                name="certificate_of_zakat">--}}
{{--                            <div class="col-12 text-danger" id="certificate_of_zakat_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="date_of_zakat_end_date">تاريخ الانتهاء</label>--}}
{{--                            <input type="text" class="form-control datepicker" id="date_of_zakat_end_date"--}}
{{--                                name="date_of_zakat_end_date">--}}
{{--                            <div class="col-12 text-danger" id="date_of_zakat_end_date_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
{{--                @if($record->certificate_of_zakat)--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="saudization_certificate">شهادة السعودة (PDF)</label>--}}
{{--                            <input type="file" class="form-control" id="saudization_certificate"--}}
{{--                                name="saudization_certificate">--}}
{{--                            <div class="col-12 text-danger" id="saudization_certificate_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="saudization_certificate_end_date">تاريخ الانتهاء</label>--}}
{{--                            <input type="text" class="form-control datepicker" id="saudization_certificate_end_date"--}}
{{--                                name="saudization_certificate_end_date">--}}
{{--                            <div class="col-12 text-danger" id="saudization_certificate_end_date_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
                @if($record->certificate_of_zakat)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="chamber_of_commerce_certificate">شهادة الغرفة
                                التجارية (PDF)</label>
                            <input type="file" class="form-control" id="chamber_of_commerce_certificate"
                                name="chamber_of_commerce_certificate">
                            <div class="col-12 text-danger" id="chamber_of_commerce_certificate_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="chamber_of_commerce_certificate_end_date">تاريخ
                                الانتهاء</label>
                            <input type="text" class="form-control datepicker"
                                id="chamber_of_commerce_certificate_end_date"
                                name="chamber_of_commerce_certificate_end_date">
                            <div class="col-12 text-danger" id="chamber_of_commerce_certificate_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
{{--                @if($record->tax_registration_certificate)--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="tax_registration_certificate">شهادة تسجيل الضريبة--}}
{{--                                (PDF)</label>--}}
{{--                            <input type="file" class="form-control" id="tax_registration_certificate"--}}
{{--                                name="tax_registration_certificate">--}}
{{--                            <div class="col-12 text-danger" id="tax_registration_certificate_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
{{--                @if($record->wage_protection_certificate)--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="wage_protection_certificate">شهادة حماية الأجور (PDF)</label>--}}
{{--                            <input type="file" class="form-control" id="wage_protection_certificate"--}}
{{--                                name="wage_protection_certificate">--}}
{{--                            <div class="col-12 text-danger" id="wage_protection_certificate_error"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
                @if($record->memorandum_of_association)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="memorandum_of_association">شهادة عقد التأسيس (PDF)</label>
                            <input type="file" class="form-control" id="memorandum_of_association"
                                name="memorandum_of_association">
                            <div class="col-12 text-danger" id="memorandum_of_association_error"></div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-4">
                    <button type="button" class="btn btn-lg btn-primary submit_btn">رفع الملفات</button>
                </div>
        </form>

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


    @endsection
    <script src = "{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>
    @section('scripts')
    <script>
    @foreach(array_keys(get_user_column_file($type)) as $_col)
    file_input_register('#{{$_col}}');
    @endforeach

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

    flatpickr(".datepicker",{defaultDate:new Date});
    </script>
    @endsection
