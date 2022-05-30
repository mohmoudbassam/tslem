@extends('CP.master')
@section('title')
انشاء مستخدم
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
        <form id="add_edit_form" method="post" action="{{route('users.add_edit')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="type">نوع المستخدم</label>
                        <select class="form-select" id="type" name="type">
                            <option @if($record->type =="admin") selected @endif value="admin">مدير نظام</option>
                            <option @if($record->type =="service_provider") selected @endif
                                value="service_provider">شركات حجاج الداخل</option>
                            <option @if($record->type =="design_office") selected @endif value="design_office">مكتب
                                هندسي</option>
                            <option @if($record->type =="Sharer") selected @endif value="Sharer">جهة مشاركة</option>
                            <option @if($record->type =="consulting_office") selected @endif
                                value="consulting_office">مكتب استشاري </option>
                            <option @if($record->type =="contractor") selected @endif value="contractor">مقاول</option>
                            <option @if($record->type =="raft_company") selected @endif value="raft_company">شركة طوافة
                            </option>
                            <option @if($record->type =="taslem_maintenance") selected @endif value="taslem_maintenance">صيانة تسليم
                            </option>
                            <option @if($record->type =="Delivery") selected @endif value="Delivery">تسليم</option>
                            <option @if($record->type =="Kdana") selected @endif value="Kdana">كدانة</option>
                        </select>
                    </div>

                </div>


                @if($record->type == "Delivery")
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="delivery_type">التخصص<span class="text-danger required-mark">*</span></label>
                        <select class="form-select" id="delivery_type" name="delivery_type">
                            <option value="">اختر التخصص </option>
                            <option value="architectural">معماري</option>
                            <option value="structural">انشائي</option>
                            <option value="electrical">كهربائي</option>
                            <option value="mechanical">ميكانيكي</option>
                            <option value="fire_protection">وقاية وحماية من الحريق</option>
                            <option value="administrative">اداري</option>
                        </select>
                    </div>
                </div>


                @endif

                @if($record->type == "Kdana")


                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="kdana_type">التخصص<span class="text-danger required-mark">*</span></label>
                        <select class="form-select" id="kdana_type" name="kdana_type">
                            <option value="">اختر التخصص </option>
                            <option value="managerial">اداري </option>
                            <option value="maintenance">صيانة</option>
                            <option value="projects">مشاريع</option>
                        </select>
                    </div>
                </div>
                @endif

                @if($record->type == "Sharer")
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="sharer_type">نوع الجهة<span class="text-danger required-mark">*</span></label>
                            <select class="form-select" id="sharer_type" name="sharer_type">
                                <option value="">اختر التخصص </option>
                                <option value="capital_municipality">أمانة العاصمة</option>
                                <option value="ministry_of_hajj">وزارة الحج</option>
                                <option value="electricity_company">شركة الكهرباء</option>
                                <option value="civil_defense">الدفاع المدني</option>
                                <option value="water_company">شركة المياه</option>
                            </select>
                        </div>
                    </div>
                    @endif


                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="name"> @if($record->type == "Kdana" || $record->type == "Delivery" || $record->type == "Sharer") اسم الشخصي المسؤول @else الاسم@endif<span
                                class="text-danger required-mark">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name"
                            placeholder="@if($record->type == "Kdana" || $record->type == "Delivery" || $record->type == "Sharer") اسم الشخصي المسؤول @else الاسم@endif">
                        <div class="col-12 text-danger" id="name_error"></div>
                    </div>
                </div>





                @if($record->company_name)
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="company_name">اسم الشركة / المؤسسة<span
                                class="text-danger required-mark">*</span></label>
                        <input type="text" class="form-control" id="company_name" value="{{old('company_name')}}"
                            name="company_name" placeholder="اسم الشركة / المؤسسة">
                        <div class="col-12 text-danger" id="company_name_error"></div>
                    </div>
                </div>
                @endif
                @if($record->company_owner_name)
                <div class="col-md-6">
                    <div class="mb-3">

                        <label class="form-label" for="company_owner_name">اسم الرئيس<span
                                class="text-danger required-mark">*</span></label>
                        <input type="text" class="form-control" value="{{old('company_owner_name')}}"
                            id="company_owner_name" name="company_owner_name" placeholder="اسم الرئيس">


                    </div>
                </div>
                @endif
                @if($record->commercial_record)
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="commercial_record"> رقم السجل التجاري</label>
                        <input type="text" class="form-control" value="{{old('commercial_record')}}"
                            id="commercial_record" placeholder="xxxxxxxxx" name="commercial_record">
                        <div class="col-12 text-danger" id="commercial_record_error"></div>
                    </div>
                </div>
                @endif
                @if($record->id_number)
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="id_number">رقم الهوية<span
                                class="text-danger required-mark">*</span></label>
                        <input type="text" class="form-control" value="{{old('id_number')}}" id="id_number"
                            name="id_number" onkeypress="return /[0-9]/i.test(event.key)" maxlength="10"
                            placeholder="xxxxxxxxxx">
                        <div class="col-12 text-danger" id="id_number_error"></div>
                    </div>
                </div>
                @endif

                @if($record->email)
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="email"> البريد الإلكتروني <span
                                class="text-danger required-mark">*</span></label>
                        <input type="email" value="{{old('email')}}" class="form-control" id="email" name="email"
                            placeholder="البريد الإلكتروني">
                        <div class="col-12 text-danger" id="email_error"></div>
                    </div>
                </div>
                @endif


                @if($record->phone)
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="phone">رقم الجوال<span
                                class="text-danger required-mark">*</span></label>
                        <input type="text" onkeypress="return /[0-9]/i.test(event.key)" value="{{old('phone')}}"
                            class="form-control" id="phone" name="phone" minlength="10" maxlength="10"
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
                            <option value="{{ $cityItem }}" @if($cityItem==$record->city || $cityItem == old('city'))
                                selected @endif>{{ $cityItem }}</option>
                            @endforeach
                        </select>
                        <div class="col-12 text-danger" id="city_error"></div>
                    </div>
                </div>
                @endif
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
                            id="password_confirmation" name="password_confirmation">
                        <div class="col-12 text-danger" id="password_confirmation_error"></div>
                    </div>
                </div>
            </div>

            @if($record->commercial_file)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="commercial_file">السجل التحاري (PDF)</label>
                        <input type="file" class="form-control" value="{{old('commercial_file')}}" id="commercial_file"
                            name="commercial_file">
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
                        <input type="text" class="form-control rating_certificate_end_date"
                            id="rating_certificate_end_date" name="rating_certificate_end_date">
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
                        <input type="text" class="form-control profession_license_end_date"
                            id="profession_license_end_date" name="profession_license_end_date">
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
                        <input type="file" class="form-control" id="certificate_of_zakat" name="certificate_of_zakat">
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
                        <input type="text" class="form-control saudization_certificate_end_date"
                            id="saudization_certificate_end_date" name="saudization_certificate_end_date">
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
            @if($record->cv_file)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="cv_file">الاعمال السابقة (PDF)</label>
                        <input type="file" class="form-control" id="cv_file" name="cv_file">
                        <div class="col-12 text-danger" id="cv_file_error"></div>
                    </div>
                </div>
            </div>
            @endif


            @if($record->company_owner_id_photo)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="company_owner_id_photo"> صورة هوية المالك (PDF)</label>
                        <input type="file" class="form-control" id="company_owner_id_photo"
                            name="company_owner_id_photo">
                        <div class="col-12 text-danger" id="company_owner_id_photo_error"></div>
                    </div>
                </div>
            </div>
            @endif

            @if($record->commissioner_id_photox)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="commissioner_id_photo"> صورة هوية المفوض (PDF)</label>
                        <input type="file" class="form-control" id="commissioner_id_photo" name="commissioner_id_photo">
                        <div class="col-12 text-danger" id="commissioner_id_photo_error"></div>
                    </div>
                </div>
            </div>
            @endif

            @if($record->commissioner_photos)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="commissioner_photo"> صورة التفويض (PDF)</label>
                        <input type="file" class="form-control" id="commissioner_photo" name="commissioner_photo">
                        <div class="col-12 text-danger" id="commissioner_photo_error"></div>
                    </div>
                </div>
            </div>
            @endif

            @if($record->nomination_letter)
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="nomination_letter">خطاب الترشيح  (PDF)</label>
                        <input type="file" class="form-control" name="nomination_letter" id="nomination_letter">
                        <div class="col-12 text-danger" id="nomination_letter_error"></div>
                    </div>
                </div>
            </div>
            @endif


        </form>

        <div class="d-flex flex-wrap gap-3">
            <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء</button>
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

<div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
</div>

@endsection


<script src="{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>

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
            @foreach(array_filter($record->makeHidden(['id', 'type'])->toArray()) as $rule => $key)
            "{{"$rule"}}": {
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
            @endforeach
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


    $('#type').change(function(e) {
        window.location = '{{route('users.get_form')}}?type=' + $(this).val()
    });



    flatpickr(".commercial_file_end_date", {
        defaultDate: (commercial_file_end_date == '')
    });
    flatpickr(".rating_certificate_end_date", {
        defaultDate: (rating_certificate_end_date == '')
    });
    flatpickr(".profession_license_end_date", {
        defaultDate: (profession_license_end_date == '')
    });
    flatpickr(".business_license_end_date", {
        defaultDate: (business_license_end_date == '')
    });
    flatpickr(".social_insurance_certificate_end_date", {
        defaultDate: (social_insurance_certificate_end_date == '')
    });
    flatpickr(".date_of_zakat_end_date", {
        defaultDate: (date_of_zakat_end_date == '')
    });
    flatpickr(".saudization_certificate_end_date", {
        defaultDate: (saudization_certificate_end_date == '')
    });
    flatpickr(".chamber_of_commerce_certificate_end_date", {
        defaultDate: (chamber_of_commerce_certificate_end_date == '')
    });
</script>

@endsection
