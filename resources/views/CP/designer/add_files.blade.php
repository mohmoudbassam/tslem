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
                               href="#general_file_panel"
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
                            <div class="tab-pane" id="general_file_panel"
                                 role="tabpanel">

                                <div class="card-body">
                                    <div>
                                        <div class="row">


                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <label class="col-12" for="reject_reason">ملف الموقع العام</label>
                                                        <div class="col-12">
                                                            <input type="file" class="form-control"
                                                                   id="general_file"
                                                                   name="general_file">
                                                        </div>
                                                        <div class="col-12 text-danger"></div>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                        <!-- end row -->
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
                <div class="card-footer">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="button" class="btn btn-lg btn-primary submit_btn" form="add_edit_form">إنشاء طلب</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="modal  bd-example-modal-lg" id="page_modal"--}}
{{--         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered modal-lg">--}}
{{--            <div class="modal-content">--}}

{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title"--}}
{{--                        id="exampleModalLongTitle"></h5>--}}

{{--                </div>--}}
{{--                <form action="" method="post" id="general_file_from" enctype="multipart/form-data">--}}

{{--                    <div class="modal-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="form-group col-lg-12 col-md-6 col-sm-12">--}}
{{--                                <div class="row">--}}
{{--                                    <label class="col-12" for="reject_reason">الرجاء ارفاق ملف الموقع العام</label>--}}
{{--                                    <div class="col-12">--}}
{{--                                        <input type="file" class="form-control" value=""--}}
{{--                                               id="general_file"--}}
{{--                                               name="general_file">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-12 text-danger" id="reject_reason_error"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <input type="hidden" name="id" value="">--}}
{{--                    <div class="modal-footer">--}}

{{--                        <button type="button" class="btn btn-secondary btn_general_file_submit" data-bs-dismiss="modal">--}}
{{--                            الغاء--}}
{{--                        </button>--}}
{{--                        <button type="button" class="btn btn-primary general_file_submit">ارسال</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

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
        file_input_cu('#general_file')

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
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'الرجاء الانتظار..........'
                    });
                },
                success:function(data) {
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
                error:function(data) {
                    KTApp.unblock('#page_modal');
                    KTApp.unblockPage();
                },
            });
            $('#page_modal').appendTo('body').modal('show');
            $(".blockUI").remove();
        });


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
            $(document).on("click", "#repeater-row-btn", function () {
                const currentTab = $("li.nav-item > a.nav-link.specialty-nav.active[aria-selected='true']");
                pushToTabs(currentTab.data("specialty"));
            });

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
                                        <div class="row">
                                            ${dt['files'].map((file) => {
                                                return `<div class="col-4"><div class="form-group"><label class="col-form-label">${file['name']}</label><a href="${file['path']}" download="" class="btn btn-block col-12 btn-primary">تحميل ملف التعهد</a> </div></div>  <div class="col-8"><div class="form-group"><label class="col-form-label required-field">${file['name']} ( بعد التعديل )</label> <input type="file" class="form-control pdf-file" name="obligations[${dt['name_en']}][${file['type']}]" accept="application/pdf" required></div> </div>`;
                                            }).join(" ")}
                                        </div>
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

        });
    </script>
@endsection
