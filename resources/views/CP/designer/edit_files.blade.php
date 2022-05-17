@extends('CP.master')
@section('title')
    المستخدمين
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
                                        <h2 class="font-size-16">تعديل الطلب</h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">

                        @foreach($specialties->where('name_en','!=','electrical') as $_specialties)

                            <li class="nav-item">
                                <a class="nav-link px-3 @if  ($loop->first) active @endif" data-bs-toggle="tab"
                                   href="#{{$_specialties->name_en}}"
                                   role="tab">{{$_specialties->name_ar}}</a>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab" href="#electrical" role="tab">الكهربائية</a>
                        </li>
                    </ul>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <form method="post" action="{{route('design_office.save_file')}}" id="add_edit_form"
                  enctype="multipart/form-data">
                @csrf

                <div class="tab-content">
                    @foreach($specialties->where('name_en','!=','electrical') as $_specialties)
                        <div class="tab-pane @if  ($loop->first) active @endif" id="{{$_specialties->name_en}}"
                             role="tabpanel">
                            <div class="card">

                                <div class="card-body">
                                    @foreach($order_specialties as $_order_specialties=> $order_services)

                                        @if($_order_specialties == $_specialties->name_en)
                                            @foreach($order_services as $service)
                                                <div class="row" id="{{$_specialties->name_en}}_old_data">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="service_id">توصيف
                                                                    الخدمة</label>

                                                                <select
                                                                    class="form-select req old_service_id"
                                                                    id="{{$_specialties->name_en}}[service_id][{{ $loop->index }}]"
                                                                    name="{{$_specialties->name_en}}[service_id][{{$loop->index }}]">
                                                                    <option value="">اختر...</option>
                                                                    @foreach($_specialties->service as $_specialties_service)
                                                                        <option value="{{$_specialties_service->id}}"
                                                                                @if($_specialties_service->id ==$service->id) selected @endif>{{$_specialties_service->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="col-12 text-danger"
                                                                     id="_error"></div>
                                                            </div>
                                                        </div>

                                                        @foreach($service->order_service_file as $file)
                                                            <div class="col-md-3">
                                                                <div class="mb-3 ">
                                                                    <label
                                                                        class="form-label">{{$file->file_type->name_ar}}</label>
                                                                    <input name="{{$file->name_en}}" type="file"
                                                                           id="file"
                                                                           data-show-preview="false"
                                                                           class="kartafile req">
                                                                    <div class="col-12 text-danger"></div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="col-md-3 ">
                                                            <div class="mb-3 unit_hide">
                                                                <label
                                                                    class="form-label">{{$service->service->unit}}</label>
                                                                <input type="text" name="unit{{$_specialties->name_en}}[unit][{{ $loop->index }}]" id="{{$_specialties->name_en}}[unit][{{ $loop->index }}]" class="form-control req "
                                                                       value="{{$service->unit}}"
                                                                       placeholder="">
                                                                <div class="col-12 text-danger"
                                                                     id="service_id_error"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
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
                                                                    class="form-select req {{$_specialties->name_en}}_service_id"
                                                                    id="service_id"
                                                                    name="service_id">
                                                                    <option value="">اختر...</option>
                                                                    @foreach($specialties->where('name_en',$_specialties->name_en)->first()->service as $service)
                                                                        <option
                                                                            value="{{$service->id}}">{{$service->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="col-12 text-danger"
                                                                     id="_error"></div>
                                                            </div>
                                                        </div>
                                                        @foreach($service->file_type as $files)
                                                            <div class="col-md-3">
                                                                <div class="mb-3 ">
                                                                    <label
                                                                        class="form-label">{{$files->name_ar}}</label>
                                                                    <input name="{{$files->name_en}}" type="file"
                                                                           id="file"
                                                                           data-show-preview="false"
                                                                           class="kartafile req">
                                                                    <div class="col-12 text-danger"></div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="col-md-3 ">
                                                            <div class="mb-3 unit_hide">
                                                                <label class="form-label"></label>
                                                                <input type="text" name="unit" class="form-control req "
                                                                       placeholder="">
                                                                <div class="col-12 text-danger"
                                                                     id="service_id_error"></div>
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


                        </div>
                    @endforeach

                    <div class="tab-pane" id="electrical" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div id="electrical_form_reporter">

                                    <div class="row">
                                        <div data-repeater-list="electrical">
                                            <div data-repeater-item="" class="mb-2">


                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="designer_id">توصيف
                                                                الخدمة</label>
                                                            <select class="form-select" id="designer_id"
                                                                    name="designer_id">
                                                                <option value="">اختر...</option>
                                                                @foreach($specialties->where('name_en','electrical')->first()->service as $service)

                                                                    <option
                                                                        value="{{$service->id}}">{{$service->name}}</option>
                                                                @endforeach
                                                                <div class="col-12 text-danger"
                                                                     id="designer_id_error"></div>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <label class="form-label">العدد</label>
                                                            <input type="number" name="number" class="form-control"
                                                                   placeholder="العدد">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <label class="form-label">كيلو/واط</label>
                                                            <input type="number" name="km" class="form-control"
                                                                   placeholder="كيلو/واط">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3 ">
                                                            <label class="form-label"
                                                                   for="formrow-password-input">خريطة</label>
                                                            <input name="file" type="file" id="file"
                                                                   data-show-preview="false" class="kartafile" multiple>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3 ">
                                                            <label class="form-label" for="formrow-password-input">جدول
                                                                احمال</label>
                                                            <input name="loads" type="file" id="loads"
                                                                   data-show-preview="false" class="kartafile" multiple>
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
                        <!-- end card -->
                    </div>

                </div>
                <input type="hidden" name="order_id" value="{{$order->id}}">


                <div class="d-flex flex-wrap gap-3">
                    <button type="button" class="btn btn-lg btn-primary submit_btn">تعديل طلب</button>
                </div>
            </form>
        </div>
        <!-- end col -->


    </div>

@endsection

@section('scripts')
    <script>
        @foreach ($specialties->where('name_en','!=','electrical') as $_specialties)
        var repeater = $('#{{$_specialties->name_en}}_form_reporter').repeater({

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
        {{--        @foreach($order_specialties as $key=>$_order_services)--}}

        {{--        @if($key===$_specialties->name_en)--}}

        {{--        repeater.setList([--}}
        {{--            @foreach($_order_services as $servics)--}}
        {{--            {--}}
        {{--                'service_id': '{{$servics->id}}',--}}
        {{--                'unit': '{{$servics->unit}}',--}}
        {{--            },--}}
        {{--            @endforeach--}}

        {{--        ]);--}}
        {{--        @endif--}}
        {{--        @endforeach--}}

        @endforeach
        $('#electrical_form_reporter').repeater({

            initEmpty: true,

            defaultValues: {
                'text-input': ''
            },

            show: function () {
                var a = document.querySelectorAll('#architect_form_reporter');
                a.forEach((e) => {

                    var fileInput = $(this).find('.kartafile');

                    fileInput.fileinput(request_file_input_attributes());

                })
                $(this).slideDown();

            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });


        $(".kartafile").fileinput({
            theme: "explorer",
            uploadUrl: "/file-upload-batch/2",
            minFileCount: 2,
            maxFileCount: 5,
            maxFileSize: 10000,
            removeFromPreviewOnError: true,
            overwriteInitial: false,
            previewFileIcon: '<i class="fas fa-file"></i>',
            initialPreview: [],
            initialPreviewAsData: true, // defaults markup
            initialPreviewConfig: [],
            showRemove: false,
            showCancel: false,
            showUpload: false,
            showPreview: true,
            browseLabel: "اضغط للاستعراض",
            msgPlaceholder: "اختر ملف",
            msgSelected: "تم الاختيار ",
            fileSingle: "ملف واحد",
            filePlural: "اكثر من ملف",
            dropZoneTitle: "سحب وافلات",
            msgZoomModalHeading: "معلومات الملف",
            dropZoneClickTitle: '<br> اضغط للاستعراض',

            uploadExtraData: {
                img_key: "1000",
                img_keywords: "happy, nature"
            },
            preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
            previewFileIconSettings: { // configure your icon file extensions
                'doc': '<i class="fas fa-file-word text-primary"></i>',
                'xls': '<i class="fas fa-file-excel text-success"></i>',
                'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                'zip': '<i class="fas fa-file-archive text-muted"></i>',
                'htm': '<i class="fas fa-file-code text-info"></i>',
                'txt': '<i class="fas fa-file-text text-info"></i>',
                'mov': '<i class="fas fa-file-video text-warning"></i>',
                'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                'jpg': '<i class="fas fa-file-image text-danger"></i>',
                'gif': '<i class="fas fa-file-image text-muted"></i>',
                'png': '<i class="fas fa-file-image text-primary"></i>'
            },
            previewFileExtSettings: { // configure the logic for determining icon file extensions
                'doc': function (ext) {
                    return ext.match(/(doc|docx)$/i);
                },
                'xls': function (ext) {
                    return ext.match(/(xls|xlsx)$/i);
                },
                'ppt': function (ext) {
                    return ext.match(/(ppt|pptx)$/i);
                },
                'zip': function (ext) {
                    return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                },
                'htm': function (ext) {
                    return ext.match(/(htm|html)$/i);
                },
                'txt': function (ext) {
                    return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                },
                'mov': function (ext) {
                    return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                },
                'mp3': function (ext) {
                    return ext.match(/(mp3|wav)$/i);
                }
            }
        });

        $('#add_edit_form').validate({
            rules: addValidationRule(),
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                $(element).addClass("is-invalid");
                element.append('#' + $(element).attr('id') + '_error');
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

            $("#add_edit_form").submit()

        });
        $('.old_service_id').bind('change', function (e) {

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
                        console.log(select_name,unit_name)
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




    </script>

@endsection
