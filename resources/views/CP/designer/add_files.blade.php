@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('style')
    <style>
        .modal {
            background-color: rgba(0, 0, 0, 0.3);
        }
        .modal-backdrop {
            position: relative;
        }
        .file-view-wrapper:hover {
            box-shadow: var(--bs-box-shadow) !important;
        }
        .file-view-icon {
            height: 180px;
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .lds-ring {
            display: inline-block;
            position: relative;
            width: 60px;
            height: 60px;
        }
        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 44px;
            height: 44px;
            margin: 8px;
            border: 4px solid #0a2373;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #0a2373 transparent transparent transparent;
        }
        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }
        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }
        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }
        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /*.blockOverlay{*/
        /*    po*/
        /*}*/
    </style>
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm order-2 order-sm-1">
                            <h1 class="card-title">تجهيز الطلب</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs-custom card-header-tabs border-top mt-3" id="pills-tab" role="tablist">
                        @foreach($specialties as $_specialties)
                            <li class="nav-item">
                                <a class="nav-link specialty-nav px-3 @if($loop->first) active @endif" data-bs-toggle="tab"
                                   href="#{{$_specialties->name_en}}"
                                   data-specialty="{{ $_specialties->name_en }}"
                                   data-id="{{ $_specialties->id }}"
                                   aria-selected="{{ $loop->first ? "true": "false" }}"
                                   role="tab">{{$_specialties->name_ar}}</a>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link px-3 " data-bs-toggle="tab"
                               href="#fire_protection_file_panel"
                               role="tab">الوقاية والحماية من الحريق</a>
                        </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 " data-bs-toggle="tab"
                                   href="#obligation_files_panel"
                                   role="tab">التعهدات</a>
                            </li>
                    </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('design_office.save_file')}}" id="add_edit_form"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="tab-content">
                            @foreach($specialties as $_specialties)
                                <div class="tab-pane @if  ($loop->first) active @endif" id="{{$_specialties->name_en}}"
                                     role="tabpanel">
                                    <div class="card">

                                        <div class="card-body ">
                                            <div id="{{$_specialties->name_en}}_form_reporter">

                                                <div class="row">
                                                    <div data-repeater-list="{{$_specialties->name_en}}">
                                                        <div data-repeater-item="" class="mb-2">


                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label required-field" for="service_id">توصيف الخدمة</label>
                                                                        <select
                                                                            class="form-select req {{$_specialties->name_en}}_service_id service_id_select"
                                                                            id="service_id"
                                                                            name="service_id">
                                                                            <option value="">اختر...</option>
                                                                            @foreach($specialties->where('name_en',$_specialties->name_en)->first()->service as $service)
                                                                                <option
                                                                                    value="{{$service->id}}">{{$service->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="col-12 text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5 ">
                                                                    <div class="mb-3 d-none">
                                                                        <label class="form-label">العدد/م</label>
                                                                        <input type="number" min="1"  name="unit" class="form-control req"
                                                                               placeholder="العدد">
                                                                        <div class="col-12 text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col d-flex flex-row justify-content-end align-items-start" style="margin-top:1.8rem;">
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-danger" id="repeater-delete-btn">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row mt-4">
                                                        <div class="col-lg-5"></div>
                                                        <div class="col">
                                                            <div data-repeater-create="" class="btn font-weight-bold btn-warning" id="repeater-row-btn">
                                                                <i class="fa fa-plus"></i> إضافة خدمة جديدة
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title mb-0">الملفات</h5>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div>
                                                <div class="row">


                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                   for="{{$_specialties->name_en}}_pdf_file">(PDF) ملف </label>
                                                            <input type="file"
                                                                   class="form-control {{$_specialties->name_en}}_pdf_file pdf_file"
                                                                   id="{{$_specialties->name_en}}_pdf_file"
                                                                   name="{{$_specialties->name_en}}_pdf_file">
                                                            <div class="col-12 text-danger"
                                                                 id="{{$_specialties->name_en}}_pdf_file"></div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                   for="{{$_specialties->name_en}}_docs_file"> (DOCS) ملف</label>
                                                            <input type="file" class="form-control" value=""
                                                                   id="{{$_specialties->name_en}}_docs_file"
                                                                   name="{{$_specialties->name_en}}_docs_file" multiple>
                                                            <div class="col-12 text-danger"
                                                                 id="{{$_specialties->name_en}}_docs_file"></div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                   for="{{$_specialties->name_en}}_cad_file">DWG ملف</label>
                                                            <input type="file" class="form-control" value=""
                                                                   id="{{$_specialties->name_en}}_cad_file"
                                                                   name="{{$_specialties->name_en}}_cad_file" multiple>
                                                            <div class="col-12 text-danger"
                                                                 id="{{$_specialties->name_en}}_cad_error"></div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <!-- end row -->
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>

                                </div>
                            @endforeach
                            <div class="tab-pane" id="fire_protection_file_panel"
                                 role="tabpanel">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label required-field" for="souls_safety_file">سلامة ارواح</label>
                                                        <input type="file" class="form-control"
                                                               id="souls_safety_file"
                                                               name="souls_safety_file" required>
                                                        <div class="col-12 text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="warning_file">انذار</label>
                                                        <input type="file" class="form-control"
                                                               id="warning_file"
                                                               name="warning_file">
                                                        <div class="col-12 text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-4">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="fire_fighter_file">اطفاء</label>
                                                        <input type="file" class="form-control"
                                                               id="fire_fighter_file"
                                                               name="fire_fighter_file">
                                                        <div class="col-12 text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="other_file">اخرى</label>
                                                        <input type="file" class="form-control"
                                                               id="other_file"
                                                               name="other_file">
                                                        <div class="col-12 text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="obligation_files_panel"
                                 role="tabpanel">
                                <div class="card-body px-0" id="obligation-wrapper">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                    </form>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-lg btn-primary submit_btn" form="add_edit_form">إنشاء طلب</button>
                </div>
            </div>
        </div>
    </div>


    <div class="" id="loader-wrapper" style="width: 100%; height: 100%; display: none; flex-direction: column; justify-content: center; align-items: center; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(153,153,153,0.64); z-index: 10000000; overflow: hidden;">
        <div class="" style=" width: 110px; height: 110px; background-color: #c0946f; display: flex; flex-direction: column; justify-content: center; align-items: center; border-radius: 10px;">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
            <span style="font-size: 11px; font-weight: bold; margin-top: 10px;">
                جاري إنشاء الطلب
            </span>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        @foreach ($specialties as $_specialties)
            $('#{{$_specialties->name_en}}_form_reporter').repeater({
            initEmpty: true,
            defaultValues: {
                'text-input': ''
            },
            show: function () {
                var a = document.querySelectorAll('#{{$_specialties->name_en}}_form_reporter');
                a.forEach((e) => {
                    var fileInput = $(this).find('.kartafile');
                    fileInput.fileinput(request_file_input_attributes());
                    var select_service = $(this).find('.{{$_specialties->name_en}}_service_id').on('change', function (e) {
                        var url = '{{ route("design_office.get_service_by_id", ":id") }}';
                        url = url.replace(':id', $(this).val());
                        var select = $(this)
                        $.ajax({
                            url: url,
                            type: "GET",
                            processData: false,
                            contentType: false,
                            beforeSend() {
                                KTApp.block('#page_modal', {
                                    overlayColor: '#000000',
                                    type: 'v2',
                                    state: 'success',
                                    message: 'الرجاء الانتظار'
                                });
                            },
                            success: function (data) {
                                var select_name = select.attr('name');
                                var unit_name = select_name.replace('service_id', 'unit');
                                unit_name = 'input[name="' + unit_name + '"]';
                                var unitInput = $(unit_name);
                                var label = unitInput.prev();
                                label.text(data.unit)
                                label.parent('.d-none').removeClass('d-none')
                                label.attr("placeholder", data.unit);
                                KTApp.unblockPage();
                            },
                            error: function (data) {
                                KTApp.unblock('#page_modal');
                                KTApp.unblockPage();
                            },
                        });
                    });
                    {{--$(this).find('.{{$_specialties->name_en}}_service_id').val($(this).find('.{{$_specialties->name_en}}_service_id').children().eq(1).attr("value")).trigger("change");--}}
                })
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        @endforeach
        file_input_cu('#souls_safety_file')
        file_input_cu('#warning_file')
        file_input_cu('#fire_fighter_file')
        file_input_cu('#other_file')
        @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_pdf_file',{},['pdf'])
        @endforeach
        @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_docs_file',{},[])
        @endforeach @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_cad_file',['dwg'])
        @endforeach
        $('#add_edit_form').validate({
            rules: addValidationRule(),
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                error.appendTo(element.next());
            },
            success: function (label, element) {
                $(element).removeClass("is-invalid");
            }
        });
        function addValidationRule() {
        }
        $('.submit_btn').click(function (e) {
            e.preventDefault();

            if (!$("[data-repeater-item]").length) {
                showAlertMessage('error', 'الرجاء اضافة خدمة جديدة')
                return false;
            }

            $('.req').each((i, e) => {
                $(e).rules("add", {required: true})
            });
            if (!$("#add_edit_form").valid()) {
                showAlertMessage('error', 'الرجاء ملئ جميع الحقول')
                return false;
            }
            if ($('#add_edit_form').find(':input').length <= 29) {
                showAlertMessage('error', 'الرجاء تعبئة الطلب')
                return false;
            }
            $.ajax({
                url : '{{route('design_office.save_file')}}',
                data : new FormData($('#add_edit_form').get(0)),
                type: "POST",
                processData: false,
                contentType: false,
                beforeSend(){
                    showLoader();
                    // KTApp.block('#page_modal', {
                    //     overlayColor: '#000000',
                    //     type: 'v2',
                    //     state: 'success',
                    //     message: 'الرجاء الانتظار..........'
                    // });
                },
                success:async function(data) {
                    await sleep(3000);
                    hideLoader();
                    if (data.success) {
                        $('#page_modal').modal('hide');
                        window.location='{{route('design_office.orders')}}'
                    } else {
                        $('#page_modal').modal('hide');
                        if (data.message) {
                            showAlertMessage('error', data.message);
                        } else {
                            showAlertMessage('error', 'حدث خطأ في النظام');
                        }
                    }
                    KTApp.unblockPage();
                },
                error: async function(data) {
                    KTApp.unblock('#page_modal');
                    KTApp.unblockPage();
                    await sleep(3000);
                    hideLoader();
                },
            });
            $('#page_modal').appendTo('body').modal('show');
            $(".blockUI").remove();
        });

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        function showLoader() {
            $("#loader-wrapper").fadeIn("slow").css({
                display: "flex"
            });
        }

        function hideLoader() {
            $("#loader-wrapper").fadeOut("slow").css({
                display: "none"
            });
        }

        function file_input_cu(selector, options,type) {
            let defaults = {
                theme: "fas",//gly
                showDrag: false,
                deleteExtraData: {
                    '_token': '{{csrf_token()}}',
                },
                browseClass: "btn btn-info",
                browseLabel: "اضغط للاستعراض",
                browseIcon: "<i class='la la-file'></i>",
                removeClass: "btn btn-danger",
                removeLabel: "delete",
                removeIcon: "<i class='fa fa-trash-o'></i>",
                showRemove: false,
                showCancel: false,
                showUpload: false,
                showPreview: false,
                msgPlaceholder: "اختر ملف",
                msgSelected: "تم الاختيار ",
                fileSingle: "ملف واحد",
                filePlural: "اكثر من ملف",
                dropZoneTitle: "سحب وافلات",
                msgZoomModalHeading: "معلومات الملف",
                dropZoneClickTitle: '<br> اضغط للاستعراض',
                initialPreview: [],
                initialPreviewShowDelete: options,
                initialPreviewAsData: true,
                initialPreviewConfig: [],
                initialPreviewFileType: 'image',
                overwriteInitial: true,
                browseOnZoneClick: true,
                captionClass: true,
                allowedFileExtensions: type,
                maxFileCount: 3,
            };
            let settings = $.extend({}, defaults, options);
            $(selector).fileinput(settings);
        }
    </script>



    <script>
        $(function () {
            let tabs = [];
            let tabsLength = 0;
            let oldTabsLength = 0;
            function pushToTabs(name) {
                if (tabs.includes(name.toLowerCase())) return null;
                 tabs.push(name.toLowerCase());
                tabsLength = tabs.length;
            }
            function popFromTabs(name) {
                tabs.splice(tabs.indexOf(name.toLowerCase()), 1);
                tabsLength = tabs.length;
            }
            function repeatCreateFunc(){
                const currentTab = $("li.nav-item > a.nav-link.specialty-nav.active[aria-selected='true']");
                pushToTabs(currentTab.data("specialty"));
            }
            $(document).on("click", "#repeater-row-btn", repeatCreateFunc);


            $(document).on("click", "#repeater-delete-btn", function () {
                const currentTab = $("li.nav-item > a.nav-link.specialty-nav.active[aria-selected='true']");
                const tabElementsLength = $(this).parents(`[data-repeater-list='${currentTab.data("specialty")}']`).children().length;
                if ( parseInt(tabElementsLength) > 1 ) return null;
                $("#obligation-wrapper").children().remove();
                popFromTabs(currentTab.data("specialty"));
                oldTabsLength = tabsLength;
            });
            async function fetchServicesObligationFiles() {
                let tabsJson = {};
                tabs.map((tab) => {
                    tabsJson[tab] = tab;
                });
                let response = await fetch(`/design-office/service/obligation/files?${$.param(tabsJson)}`);
                return await (await response).json();
            }
            function prepareObligationFilesUploader(data) {
                data.map((dt) => {
                    $("#obligation-wrapper").append(`
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h1 class="card-title">
                                            ${dt['name_ar']}
                                        </h1>
                                    </div>
                                    <div class="card-body" id="">
                                            ${dt['files'].map((file) => {
                                                return `<div class="row pb-4 mb-3 border-bottom"><div class="col-4"><div class="form-group"><label class="col-form-label">${file['name']}</label><a href="${file['path']}" download="" class="btn btn-block col-12 btn-primary">تحميل ملف التعهد</a> </div></div>  <div class="col-8"><div class="form-group"><label class="col-form-label required-field">${file['name']} ( بعد التعديل )</label> <input type="file" class="form-control pdf-file" name="obligations[${dt['name_en']}][${file['type']}]" accept="application/pdf" required></div> </div></div>`;
                                            }).join(" ")}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
                file_input_cu($(document).find(".pdf-file"), {}, ['pdf']);
            }
            $("li.nav-item > a.nav-link[href='#obligation_files_panel']").on("click", async function () {
                if ( tabs.length < 1 ) {
                    $("#obligation-wrapper").append(`<siv class="row"><div class="col-12"><div class="alert alert-danger"><span>من فضلك قم بإضافة بعض الخدمات للطلب لكي يتسنى لك تحميل تعهدات الخدمة</span></div></div></div>`);
                    return null;
                } else {
                    if ( oldTabsLength !== tabsLength ) {
                        $("#obligation-wrapper").children().remove();
                        const obligationWrapper = $("#obligation-wrapper");
                        obligationWrapper.append(`<div class="row"><div class="col-12"><div class="alert alert-info"><i class="fa fa-info-circle mx-2"></i><span>من فضلك قم بتحميل ملفات التعهد ومن ثم قم بإعادة رفعها بعد اكمال البيانات</span></div></div></div>`);
                        let response = await fetchServicesObligationFiles();
                        prepareObligationFilesUploader(response['data']);
                        oldTabsLength = tabsLength;
                    }
                }
            });

            $('#repeater-row-btn').click();
        });
    </script>
@endsection
