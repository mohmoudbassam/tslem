@extends('CP.master')
@section('title')
    الملف الشخصي
@endsection
@section('content')
<link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css?v=1')}}"/>
<style>
.file-preview {
    display: none;
}
</style>
    @if ($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @if (session('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <li>{{ session('success') }}</li>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title m-0">تعديل الملف الشخصي</h1>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <form id="add_edit_form" method="post" action="{{ in_array(auth()->user()->verified, [0, 2]) ? route('after_reject'): route('save_profile')}}" enctype="multipart/form-data">
                            @csrf


                                <div class="row">
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
                                                <label class="form-label required-field" for="company_owner_name">اسم المالك</label>
                                                <input type="text" class="form-control" value="{{$user->company_owner_name}}"
                                                       id="company_owner_name"
                                                       name="company_owner_name" placeholder="اسم المالك">
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
                                    @if($record->commercial_record)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required-field" for="commercial_record"> رقم السجل التجاري</label>
                                                <input type="text" onkeypress="return /[0-9]/i.test(event.key)" class="form-control"
                                                       value="{{$user->commercial_record}}"
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
                                    @if($record->telephone)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="telephone">الهاتف<span class="text-danger required-mark">*</span></label>
                                                <input type="text" value="{{$user->telephone}}" class="form-control" id="telephone"
                                                       name="telephone"
                                                       placeholder="الهاتف">
                                                <div class="col-12 text-danger" id="telephone_error"></div>
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
                                    @if($record->commercial_file)
                                        <div class="row m-0 p-0">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="commercial_file">السجل التحاري (PDF)</label>
                                                    <input type="file" class="form-control"
                                                           id="commercial_file" name="commercial_file">
                                                    <div class="col-12 text-danger" id="commercial_file_error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="commercial_file_end_date">تاريخ انتهاء السجل التجاري</label>
                                                    <input type="text" class="form-control flatpickr"
                                                           value="{{$user->commercial_file_end_date}}" id="commercial_file_end_date"
                                                           name="commercial_file_end_date">
                                                    <div class="col-12 text-danger" id="commercial_file_end_date_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->rating_certificate)
                                        <div class="row m-0 p-0">
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
                                                    <input type="text" class="form-control flatpickr" id="rating_certificate_end_date"
                                                           name="rating_certificate_end_date"  value="{{$user->rating_certificate_end_date}}">
                                                    <div class="col-12 text-danger" id="rating_certificate_end_date_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->address_file)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="address_file">العنوان الوطني (PDF)</label>
                                                <input type="file" class="form-control" name="address_file" id="address_file">
                                                <div class="col-12 text-danger" id="address_file_error"></div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->profession_license)
                                        <div class="row m-0 p-0">
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
                                                    <input type="text" class="form-control flatpickr" id="profession_license_end_date"
                                                           name="profession_license_end_date" value="{{$user->profession_license_end_date}}">
                                                    <div class="col-12 text-danger" id="profession_license_date_end_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->business_license)
                                        <div class="row m-0 p-0">
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
                                                    <input type="text" class="form-control flatpickr" id="business_license_end_date"
                                                           name="business_license_end_date" value="{{$user->business_license_end_date}}">
                                                    <div class="col-12 text-danger" id="business_license_end_date_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->social_insurance_certificate)
                                        <div class="row m-0 p-0">
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
                                                    <input type="text" class="form-control flatpickr" value="{{$user->social_insurance_certificate_end_date}}"
                                                           id="social_insurance_certificate_end_date" name="social_insurance_certificate_end_date">
                                                    <div class="col-12 text-danger" id="social_insurance_certificate_end_date_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->certificate_of_zakat)
                                        <div class="row m-0 p-0">
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
                                                    <input type="text" class="form-control flatpickr" id="date_of_zakat_end_date"
                                                           name="date_of_zakat_end_date" value="{{$user->date_of_zakat_end_date}}">
                                                    <div class="col-12 text-danger" id="date_of_zakat_end_date_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->saudization_certificate)
                                        <div class="row m-0 p-0">
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
                                                    <input type="text" class="form-control flatpickr" id="saudization_certificate_end_date"
                                                           name="saudization_certificate_end_date" value="{{$user->saudization_certificate_end_date}}">
                                                    <div class="col-12 text-danger" id="saudization_certificate_end_date_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->chamber_of_commerce_certificate)
                                        <div class="row m-0 p-0">
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
                                                    <input type="text" class="form-control flatpickr" value="{{$user->chamber_of_commerce_certificate_end_date}}"
                                                           id="chamber_of_commerce_certificate_end_date"
                                                           name="chamber_of_commerce_certificate_end_date">
                                                    <div class="col-12 text-danger" id="chamber_of_commerce_certificate_end_date_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->tax_registration_certificate)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="tax_registration_certificate">شهادة تسجيل الضريبة
                                                    (PDF)</label>
                                                <input type="file" class="form-control" id="tax_registration_certificate"
                                                       name="tax_registration_certificate">
                                                <div class="col-12 text-danger" id="tax_registration_certificate_error"></div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->wage_protection_certificate)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="wage_protection_certificate">شهادة حماية الأجور (PDF)</label>
                                                <input type="file" class="form-control" id="wage_protection_certificate"
                                                       name="wage_protection_certificate">
                                                <div class="col-12 text-danger" id="wage_protection_certificate_error"></div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->memorandum_of_association)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="memorandum_of_association"> عقد التأسيس (PDF)</label>
                                                <input type="file" class="form-control" id="memorandum_of_association"
                                                       name="memorandum_of_association">
                                                <div class="col-12 text-danger" id="memorandum_of_association_error"></div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($record->type == 'contractor')
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="previous_works">الاعمال السابقة (PDF)</label>
                                                <input type="file" class="form-control" id="previous_works"
                                                       name="previous_works">
                                                <div class="col-12 text-danger" id="previous_works_error"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($record->company_owner_id_photo)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="company_owner_id_photo"> صورة هوية  المالك (PDF)</label>
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


                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-lg btn-primary submit_btn" form="add_edit_form">تعديل</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->type == "contractor" and auth()->user()->contractor_types()->count() == 0)
        <div class="modal fade" id="choose-contractor-specialty-modal" tabindex="-1" role="dialog" aria-labelledby="choose-contractor-specialty-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choose-contractor-specialty-modal-title">اختيار التخصص</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle">
                                        من فضلك قم بإختيار التخصص الخاص بك
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label required-field" for="contractor-specialty">التخصص</label>
                                    <select class="form-control select2" name="contractor_specialty" id="contractor-specialty" required>
                                        <option value="1">عام</option>
                                        <option value="2">الوقاية والحماية من الحرائق</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" id="submit-contractor-specialty-btn" class="btn btn-primary" data-dismiss="modal">موافق</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')

    <script>
        @if(auth()->user()->type == "service_provider" and !is_null(auth()->user()->parent_id))
            @foreach(array_keys(get_user_column_file("raft_center")) as $_col)
                file_input('#{{$_col}}', {
                    initialPreview: '{{ asset('storage/'.$user->{$_col}) }}',
                });
            @endforeach
        @else
            @foreach(array_keys($col_file) as $_col)
                @if($user->{$_col})
                    file_input('#{{$_col}}', {
                        initialPreview: '{{ asset('storage/'.$user->{$_col}) }}',
                    });
                @else
                    file_input('#{{$_col}}');
                @endif
            @endforeach
        @endif


        $('#add_edit_form').validate({
            rules: {
                @foreach(array_filter($record->makeHidden(['id','type'])->toArray()) as $rule=> $key)
                @if(!$user->{$rule})
                "{{"$rule"}}": {
                    required: true,
                },
                @endif
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
                required: true,
                number: true
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

        flatpickr(".flatpickr");
    </script>

    @if(auth()->user()->type == "contractor" and auth()->user()->contractor_types()->count() == 0)
        <script>
            $(function () {
                // $('.select2').select2({
                //     width: "100%",
                // });
                $("#choose-contractor-specialty-modal").modal({backdrop: 'static', keyboard: false});
                $("#choose-contractor-specialty-modal").modal("show");

                async function update_contractor_specialty(specialty) {
                    let response = await fetch("/contractor/update_specialty", {
                        method: "POST",
                        body: JSON.stringify({
                            specialty_id: specialty
                        }),
                        headers: {
                            'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                            'Accept': 'application/json',
                            'Content': 'application/json',
                            'Content-Type': 'application/json'
                        },
                    });

                    return await (await response).json();
                }

                $("#submit-contractor-specialty-btn").on("click", async function (event) {
                    event.preventDefault();

                    let specialty = $("#contractor-specialty").val();
                    let response = await update_contractor_specialty(specialty);

                    if ( response['success'] ) {
                        showAlertMessage("success", response['message']);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showAlertMessage("error", response['message']);
                    }
                });
            })
        </script>
    @endif
@endsection
