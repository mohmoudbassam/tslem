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
                            <input type="text" class="form-control commercial_file_end_date"
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
                            <input type="text" class="form-control rating_certificate_end_date" id="rating_certificate_end_date"
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
                            <input type="text" class="form-control profession_license_end_date" id="profession_license_end_date"
                                name="profession_license_end_date">
                            <div class="col-12 text-danger" id="profession_license_date_end_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->business_license)
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
                            <input type="text" class="form-control business_license_end_date" id="business_license_end_date"
                                name="business_license_end_date">
                            <div class="col-12 text-danger" id="business_license_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->social_insurance_certificate)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="social_insurance_certificate">رخصة التأمينات
                                الإجتماعية (PDF)</label>
                            <input type="file" class="form-control" id="social_insurance_certificate"
                                name="social_insurance_certificate">
                            <div class="col-12 text-danger" id="social_insurance_certificate_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="social_insurance_certificate_end_date">تاريخ
                                الانتهاء</label>
                            <input type="text" class="form-control social_insurance_certificate_end_date"
                                id="social_insurance_certificate_end_date" name="social_insurance_certificate_end_date">
                            <div class="col-12 text-danger" id="social_insurance_certificate_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->certificate_of_zakat)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="certificate_of_zakat">رخصة الزكاة والدخل (PDF)</label>
                            <input type="file" class="form-control" id="certificate_of_zakat"
                                name="certificate_of_zakat">
                            <div class="col-12 text-danger" id="certificate_of_zakat_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="date_of_zakat_end_date">تاريخ الانتهاء</label>
                            <input type="text" class="form-control date_of_zakat_end_date" id="date_of_zakat_end_date"
                                name="date_of_zakat_end_date">
                            <div class="col-12 text-danger" id="date_of_zakat_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->saudization_certificate)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="saudization_certificate">شهادة السعودة (PDF)</label>
                            <input type="file" class="form-control" id="saudization_certificate"
                                name="saudization_certificate">
                            <div class="col-12 text-danger" id="saudization_certificate_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="saudization_certificate_end_date">تاريخ الانتهاء</label>
                            <input type="text" class="form-control saudization_certificate_end_date" id="saudization_certificate_end_date"
                                name="saudization_certificate_end_date">
                            <div class="col-12 text-danger" id="saudization_certificate_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->chamber_of_commerce_certificate)
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
                            <input type="text" class="form-control chamber_of_commerce_certificate_end_date"
                                id="chamber_of_commerce_certificate_end_date"
                                name="chamber_of_commerce_certificate_end_date">
                            <div class="col-12 text-danger" id="chamber_of_commerce_certificate_end_date_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->tax_registration_certificate)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="tax_registration_certificate">شهادة تسجيل الضريبة
                                (PDF)</label>
                            <input type="file" class="form-control" id="tax_registration_certificate"
                                name="tax_registration_certificate">
                            <div class="col-12 text-danger" id="tax_registration_certificate_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->wage_protection_certificate)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="wage_protection_certificate">شهادة حماية الأجور (PDF)</label>
                            <input type="file" class="form-control" id="wage_protection_certificate"
                                name="wage_protection_certificate">
                            <div class="col-12 text-danger" id="wage_protection_certificate_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                @if($record->memorandum_of_association)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="memorandum_of_association"> عقد التأسيس (PDF)</label>
                            <input type="file" class="form-control" id="memorandum_of_association"
                                name="memorandum_of_association">
                            <div class="col-12 text-danger" id="memorandum_of_association_error"></div>
                        </div>
                    </div>
                </div>
                @endif
                    @if($record->type == 'contractor')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="cv_file">الاعمال السابقة (PDF)</label>
                                    <input type="file" class="form-control" id="cv_file"
                                           name="cv_file">
                                    <div class="col-12 text-danger" id="cv_file_error"></div>
                                </div>
                            </div>
                        </div>
                    @endif


                @if($record->company_owner_id_photo)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="company_owner_id_photo"> صورة هوية صاحب الشركة  (PDF)</label>
                            <input type="file" class="form-control" id="company_owner_id_photo"
                                name="company_owner_id_photo">
                            <div class="col-12 text-danger" id="company_owner_id_photo_error"></div>
                        </div>
                    </div>
                </div>
                @endif

                @if($record->commissioner_id_photo)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="commissioner_id_photo"> صورة هوية  المفوض (PDF)</label>
                            <input type="file" class="form-control" id="commissioner_id_photo"
                                name="commissioner_id_photo">
                            <div class="col-12 text-danger" id="commissioner_id_photo_error"></div>
                        </div>
                    </div>
                </div>
                @endif

                @if($record->commissioner_photo)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="commissioner_photo"> صورة التفويض (PDF)</label>
                            <input type="file" class="form-control" id="commissioner_photo"
                                name="commissioner_photo">
                            <div class="col-12 text-danger" id="commissioner_photo_error"></div>
                        </div>
                    </div>
                </div>
                @endif


                <div class="mt-4">
                    <button type="button" class="btn btn-lg btn-primary submit_btn">رفع الملفات</button>
                </div>
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


    let commercial_file_end_date = "{{old('commercial_file_end_date')}}";
    let rating_certificate_end_date = "{{old('rating_certificate_end_date')}}";
    let profession_license_end_date = "{{old('profession_license_end_date')}}";
    let business_license_end_date = "{{old('business_license_end_date')}}";
    let social_insurance_certificate_end_date = "{{old('social_insurance_certificate_end_date')}}";
    let date_of_zakat_end_date = "{{old('date_of_zakat_end_date')}}";
    let saudization_certificate_end_date = "{{old('saudization_certificate_end_date')}}";
    let chamber_of_commerce_certificate_end_date = "{{old('chamber_of_commerce_certificate_end_date')}}";


    @foreach(array_keys(get_user_column_file($type)) as $_col)
    file_input_register('#{{$_col}}');
    @endforeach

    @if($record->type == 'contractor')
    file_input_register('#cv_file');
    @endif
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
            @if($record->type == 'contractor')
            "cv_file": {
                required: true,
            },
                @endif


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


    flatpickr(".commercial_file_end_date",{defaultDate: (commercial_file_end_date == '') ? new Date : commercial_file_end_date});
    flatpickr(".rating_certificate_end_date",{defaultDate: (rating_certificate_end_date == '') ? new Date : rating_certificate_end_date});
    flatpickr(".profession_license_end_date",{defaultDate: (profession_license_end_date == '') ? new Date : profession_license_end_date});
    flatpickr(".business_license_end_date",{defaultDate: (business_license_end_date == '') ? new Date : business_license_end_date});
    flatpickr(".social_insurance_certificate_end_date",{defaultDate: (social_insurance_certificate_end_date == '') ? new Date : social_insurance_certificate_end_date});
    flatpickr(".date_of_zakat_end_date",{defaultDate: (date_of_zakat_end_date == '') ? new Date : date_of_zakat_end_date});
    flatpickr(".saudization_certificate_end_date",{defaultDate: (saudization_certificate_end_date == '') ? new Date : saudization_certificate_end_date});
    flatpickr(".chamber_of_commerce_certificate_end_date",{defaultDate: (chamber_of_commerce_certificate_end_date == '') ? new Date : chamber_of_commerce_certificate_end_date});


    </script>
    @endsection
