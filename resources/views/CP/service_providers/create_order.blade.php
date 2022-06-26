@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('content')

    <style>
        .select2-selection__rendered {
            line-height: 36px !important;
        }
        .select2-container .select2-selection--single {
            height: 40px !important;
        }
        .select2-selection__arrow {
            height: 39px !important;
        }
        Share

    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/css/libs/animate.css">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء طلب</a></li>
                        <li class="breadcrumb-item"><a href="{{route('services_providers.orders')}}">الطلبات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12" id="designer-type-warning-alert-wrapper" style="display: none;">
            <div class="alert alert-warning d-flex justify-content-between wow" id="designer-type-warning-alert">
                <div class="d-flex flex-row align-items-center" style="width: 80%;">
                    <i class="fa fa-info-circle mx-2"></i>
                    <b>
                        المكتب الذي قمت بإختياره ليس من ضمن إختصاصاته ( الحماية والوقاية من الحريق ) نرجوا منكم التنويه على المكتب الذي تم اختياره بإعتماد التصاميم من إحدى المكاتب المعتمدة في الحماية والوقاية من الحريق.
                    </b>

                </div>

                <b class="btn text-white bg-success" id="agree-to-designer-has-no-fire" style="font-weight: bolder; cursor: pointer;">
                    لا مانع لدي
                </b>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-0">
                        إنشاء طلب جديد
                    </h4>
                </div>
                <div class="card-body">
                    <form id="add_edit_form" method="post" action="{{route('services_providers.save_order')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="0" id="agree_to_designer_has_no_fire_specialty" name="agree_to_designer_has_no_fire_specialty">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-group" id="designer_id_parent">
                                    <label class="form-label" for="designer_id">المكتب الهندسي</label>
                                    <select class="form-select select2" id="designer_id" name="designer_id">
                                        <option  value="">اختر...</option>
                                        @foreach($designers as $designer)
                                            <option  value="{{$designer->id}}">{{$designer->company_name}}</option>
                                        @endforeach
                                        <div class="col-12 text-danger" id="designer_id_error"></div>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="button" class="btn btn-lg btn-primary submit_btn" id="submit-order">إنشاء طلب</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

    <div class="modal fade" id="obligations-modal" tabindex="-1" role="dialog" aria-labelledby="obligations-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="obligations-modal-title">تعهد وإقرار</h5>
                </div>
                <div class="modal-body">
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <h5 class="font-bold">
                                اتعهد في حال صدور رخصة الاضافات و إعتمادها  بأن التزم  بالتالي  :-
                            </h5>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <ol>
                                <li class="my-3 mark" style="font-size: 14px; font-weight: bolder;">
                                    الالتزام بتنفيذ جميع الأعمال الإضافية المطلوبة و الموضحة بهذا التصريح من قبلنا و تحت مسؤوليتنا وفقاً للشروط و المواصفات و الادلة ومتابعة الإشراف و الإلتزام بالتنسيق مع مقاولي التشغيل و الصيانة في المشروع .
                                </li>
                                <li class="my-3 mark" style="font-size: 14px; font-weight: bolder;">
                                    إزالة الإضافات و إعادة الوضع الى ما كان عليه سابقا متى ما طلب مني الإزالة و عدم الاعتراض .
                                </li>
                                <li class="my-3 mark" style="font-size: 14px; font-weight: bolder;">
                                    عدم إعاقة فرق المتابعة في أداء عملها و التعاون التام معها.
                                </li>
                                <li class="my-3 mark" style="font-size: 14px; font-weight: bolder;">
                                    التعاقد مع إحدى شركات نقل المخلفات و عدم رميها في الممرات و  الطرق و الشوارع العامة .
                                </li>
                                <li class="my-3 mark" style="font-size: 14px; font-weight: bolder;">
                                    للجهات الرسمية الحق في العودة بتكاليف الإصلاحات و الغرامات المتناسبة في حالة وجود تلف أو مخالفة .
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-check" style="margin-right: 15px;">
                                <input class="form-check-input" type="checkbox" value="" id="agree_checkbox">
                                <label class="form-check-label" for="agree_checkbox" style="font-weight: bold;">
                                    اوافق على الاقرار والتعهد
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" id="agree-to-obligations-btn" class="btn btn-primary" data-dismiss="modal">موافق</button>
                    <button type="button" id="close-obligations-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        new WOW().init();
    </script>

    <script>
        file_input('#files');
        $('#add_edit_form').validate({
            rules: {
                "designer_id": {
                    required: true,
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
    </script>

    <script>
        $(function () {
            let agreed = parseInt("{{ auth()->user()->agree_to_obligation }}");
            let agreed_to_designer_has_no_fire = false;

            $(".select2").select2({});
            $(".designer_id").select2({
                dropdownParent: $("#designer_id_parent")
            });

            $("#obligations-modal").modal({backdrop: 'static', keyboard: false});

            $("#designer_id").on("select2:opening", function (event) {
                if ( !agreed ) {
                    event.preventDefault();
                    $("#obligations-modal").modal("show");
                }
            });

            $("#submit-order").on("click", function (event) {
                event.preventDefault();

                if (!$("#add_edit_form").valid())
                    return false;

                if ( !agreed ) {
                    $("#obligations-modal").modal("show");
                    return false;
                }

                if ( !agreed_to_designer_has_no_fire ) {
                    $("#designer-type-warning-alert").addClass("shake");
                    showAlertMessage("warning", "من فضلك قم بالموافقة بأنه لا مانع لديك من اختيار هذا المكتب الهندسي");
                    setTimeout(() => {
                        $("#designer-type-warning-alert").removeClass("shake");
                    }, 500);
                    return false;
                }

                $('#add_edit_form').submit();
            });

            $("#close-obligations-modal").on("click", function () {
                $("#obligations-modal").modal("hide");
            });

            $("#agree-to-obligations-btn").on("click",  async function () {
                if ( !$("#agree_checkbox").prop("checked") ) {
                    showAlertMessage("error", "من فضلك قم بالنوافقة على الاقرار والتعهد")
                    return null;
                }

                let response = await (await fetch(`/service-providers/obligations/agree`, {
                    METHOD: "GET",
                    headers: {
                        'accept': 'application/json'
                    },
                })).json();

                if ( !response['success'] ) {
                    showAlertMessage("error", response['message']);
                    return;
                }

                showAlertMessage("success", response['message']);
                agreed = true;
                $("#obligations-modal").modal("hide");
                $("#designer_id").select2("open");
            });






            // Getting Designer Type After Selecting One Designer.

            $("#agree-to-designer-has-no-fire").on("click", function () {
                $("#agree_to_designer_has_no_fire_specialty").val(1);
                $(this).slideUp("slow");
                agreed_to_designer_has_no_fire = true;
            });

            async function getDesignerType(id) {
                let response = await fetch(`/service-providers/${id}/design/types`, {
                    method: "GET",
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                return await (await response).json();
            }

            function showDesignerWarningMessage() {
                $("#designer-type-warning-alert-wrapper").slideDown("slow");
            }

            function hideDesignerWarningMessage() {
                $("#designer-type-warning-alert-wrapper").slideUp("slow", function () {
                    $("#agree-to-designer-has-no-fire").slideDown("slow");
                    $("#agree_to_designer_has_no_fire_specialty").val(0);
                    agreed_to_designer_has_no_fire = false;
                });
            }

            $("#designer_id").on("change", async function () {
                let designer = $(this).val();
                let response = await getDesignerType(designer);
                if ( response['success'] ) {
                    let resultLength = response['data'].filter((dt) => {
                        return dt['type'] === "fire";
                    }).length;
                    if ( resultLength === 0 ) {
                        showDesignerWarningMessage();
                        agreed_to_designer_has_no_fire = false;
                    } else {
                        hideDesignerWarningMessage();
                        agreed_to_designer_has_no_fire = true;
                    }
                } else {
                    showAlertMessage("error", response['message']);
                }
            });
        });
    </script>
@endsection
