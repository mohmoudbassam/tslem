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
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm order-2 order-sm-1">
                            <div class="d-flex align-items-start mt-3 mt-sm-0">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xl me-3">
                                        <img src="" alt="" class="img-fluid rounded-circle d-block">
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <h2 class="font-size-16">تجهيز الطلب</h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">

                        @foreach($specialties as $_specialties)

                            <li class="nav-item">
                                <a class="nav-link px-3 @if  ($loop->first) active @endif" data-bs-toggle="tab"
                                   href="#{{$_specialties->name_en}}"
                                   role="tab">{{$_specialties->name_ar}}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
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
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="service_id">توصيف
                                                                    الخدمة</label>
                                                                <select
                                                                    class="form-select req {{$_specialties->name_en}}_service_id service_id_select"

                                                                    name="service_id">
                                                                    <option value="">اختر...</option>
                                                                    @foreach($specialties->where('name_en',$_specialties->name_en)->first()->service as $service)
                                                                        <option
                                                                            value="{{$service->id}}">{{$service->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="col-12 text-danger"
                                                                     ></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 ">
                                                            <div class="mb-3 d-none">
                                                                <label class="form-label">العدد/م</label>
                                                                <input type="number" min="1"  name="unit" class="form-control req"
                                                                       placeholder="العدد">
                                                                <div class="col-12 text-danger"
                                                                     ></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <div class="col-lg-5"></div>
                                                <div class="col">
                                                    <div data-repeater-create=""
                                                         class="btn font-weight-bold btn-warning">
                                                        <i class="la la-plus"></i> إضافة
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
                                                           for="{{$_specialties->name_en}}_pdf_file">Pdf ملف </label>
                                                    <input type="file"
                                                           class="form-control {{$_specialties->name_en}}_pdf_file"
                                                           id="{{$_specialties->name_en}}_pdf_file"
                                                           name="{{$_specialties->name_en}}_pdf_file">
                                                    <div class="col-12 text-danger"
                                                         id="{{$_specialties->name_en}}_pdf_file"></div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                           for="{{$_specialties->name_en}}_docs_file"> ملف docs</label>
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
                                                           for="{{$_specialties->name_en}}_cad_file">CAD ملف</label>
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


                </div>


                <input type="hidden" name="order_id" value="{{$order->id}}">


                <div class="d-flex flex-wrap gap-3">
                    <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء طلب</button>
                </div>
            </form>
        </div>


    </div>
    <div class="modal  bd-example-modal-lg" id="page_modal"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLongTitle"></h5>

                </div>
                <form action="" method="post" id="general_file_from" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-6 col-sm-12">
                                <div class="row">
                                    <label class="col-12" for="reject_reason">الرجاء ارفاق ملف الموقع العام</label>
                                    <div class="col-12">
                                        <input type="file" class="form-control" value=""
                                               id="general_file"
                                               name="general_file">
                                    </div>
                                    <div class="col-12 text-danger" id="reject_reason_error"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" name="id" value="">
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary btn_general_file_submit" data-bs-dismiss="modal">
                            الغاء
                        </button>
                        <button type="button" class="btn btn-primary general_file_submit">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#general_file_from').validate({
            rules: {
                "general_file": {
                    required:true
                }
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                error.appendTo(element.next());
            },
            success: function (label, element) {
                element.next().hide()
                $(element).removeClass("is-invalid");
            }
        });
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
                                console.log(data);
                                KTApp.unblock('#page_modal');
                                KTApp.unblockPage();
                            },
                        });
                    });

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
        file_input_cu('#{{$_specialties->name_en}}_pdf_file')

        @endforeach
        @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_docs_file')

        @endforeach @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_cad_file')

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
                console.log(element);
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
            if ($('#add_edit_form').find(':input').length <= 39) {
                showAlertMessage('error', 'الرجاء تعبئة الطلب')
                return false;
            }

            $('#page_modal').appendTo('body').modal('show');
            $(".blockUI").remove();
            // $("#add_edit_form").submit()

        });
        $('.general_file_submit').click(function (e) {
            e.preventDefault();
            if (!  $('#general_file_from').valid()) {
                showAlertMessage('error', 'الرجاء إرفاق الملف العام')
                return false;
            }


            $.ajax({
                url : '{{route('design_office.save_file')}}',
                data : new FormData($('#add_edit_form').append($('#general_file')).get(0)),
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

                      window.location='{{route('design_office')}}'
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
                    console.log(data);
                    KTApp.unblock('#page_modal');
                    KTApp.unblockPage();
                },
            });
        });

        function file_input_cu(selector, options) {
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
                showPreview: true,
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
                maxFileCount: 3,
            };
            let settings = $.extend({}, defaults, options);
            $(selector).fileinput(settings);
        }




    </script>

@endsection
