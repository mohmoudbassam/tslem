@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('style')
    <style>
        .input-icon {
            float: left;
        }
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
                                        <h2 class="font-size-16">تعديل الطلب</h2>

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

                            <li class="nav-item">
                                <a class="nav-link px-3 " data-bs-toggle="tab"
                                   href="#general_file_panel"
                                   role="tab">الوقاية والحماية من الحريق</a>
                            </li>

                    </ul>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <form method="post" action="{{route('design_office.edit_file_action')}}" id="add_edit_form"
                  enctype="multipart/form-data">
                @csrf
                <div class="tab-content">

                    @foreach($specialties as $_specialties)

                        <div class="tab-pane @if  ($loop->first) active @endif" id="{{$_specialties->name_en}}"
                             role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    @if(isset($order_specialties[$_specialties->name_en]))
                                        @foreach($order_specialties[$_specialties->name_en] as $_services)

                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="service_id">توصيف
                                                                الخدمة</label>
                                                            <select
                                                                class="form-select req"

                                                                name="service[{{$_services->id}}][service_id]">
                                                                @foreach($system_specialties_services->where('name_en',$_specialties->name_en)->first()->service as $services)

                                                                    <option value="{{$services->id}}"
                                                                            @if($services->id == $_services->service_id) selected @endif>{{$services->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="col-12 text-danger"
                                                                 ></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="mb-3 unit_hide">
                                                            <label
                                                                class="form-label">{{$_services->service->unit}}</label>
                                                            <input type="number" min="1" name="service[{{$_services->id}}][unit]" value="{{$_services->unit}}"
                                                                   class="form-control req"
                                                                   placeholder="">

                                                            <div class="col-12 text-danger"
                                                                 id="service_id_error"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 " style="margin-top:1.8rem;">
                                                        <div class="mb-3">

                                                            <a class="btn btn-danger"
                                                               href="{{route('design_office.delete_service',['service'=>$_services])}}"><i
                                                                    class="fa fa-trash-alt"></i></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
                                                                    class="form-select req"

                                                                    name="service_id">
                                                                    <option value="">اختر...</option>
                                                                    @foreach($specialties->where('name_en',$_specialties->name_en)->first()->service as $service)

                                                                        <option
                                                                            value="{{$service->id}}">{{$service->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="col-12 text-danger" ></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 ">
                                                            <div class="mb-3 unit_hide">
                                                                <label class="form-label">عدد</label>
                                                                <input type="number" min="1"  name="unit" class="form-control req"
                                                                       placeholder="">
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
                                <div class="row mt-5">

                                    @foreach($filess->where('specialties.name_en',$_specialties->name_en) as $files)
                                        @if($files->type ==1)
                                            <div class="col-md-offset-3 col-md-2">
                                                <div class="panel panel-default bootcards-file">

                                                    <div class="list-group">
                                                        <div class="list-group-item">
                                                            <a href="#">
                                                                <i class="fa fa-file-pdf fa-4x"></i>
                                                            </a>
                                                            <h5 class="list-group-item-heading">
                                                                <a href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                    {{$files->real_name}}
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div class="list-group-item">
                                                            ملف pdf
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-success"
                                                                   href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    تنزيل
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-danger"
                                                                   href="{{route('design_office.delete_file',['file'=>$files->id])}}">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                    حذف
                                                                </a>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($files->type ==2)
                                            <div class="col-md-offset-3 col-md-2">
                                                <div class="panel panel-default bootcards-file">

                                                    <div class="list-group">
                                                        <div class="list-group-item">
                                                            <a href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                <i class="fa fa-file-pdf fa-4x"></i>
                                                            </a>
                                                            <h5 class="list-group-item-heading">
                                                                <a href="#">
                                                                    {{$files->real_name}}
                                                                </a>
                                                            </h5>

                                                        </div>
                                                        <div class="list-group-item">
                                                            ملف cad
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-success"
                                                                   href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    تنزيل
                                                                </a>
                                                            </div>

                                                        </div>
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-danger"
                                                                   href="{{route('design_office.delete_file',['file'=>$files->id])}}">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                    حذف
                                                                </a>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($files->type ==3)
                                            <div class="col-md-offset-3 col-md-2">
                                                <div class="panel panel-default bootcards-file">

                                                    <div class="list-group">
                                                        <div class="list-group-item">
                                                            <a href="#">
                                                                <i class="fa fa-file-pdf fa-4x"></i>
                                                            </a>
                                                            <h5 class="list-group-item-heading">
                                                                <a href="#">
                                                                    {{$files->real_name}}
                                                                </a>
                                                            </h5>

                                                        </div>
                                                        <div class="list-group-item">
                                                            ملف docs
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-success"
                                                                   href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    تنزيل
                                                                </a>
                                                            </div>


                                                        </div>
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-danger"
                                                                   href="{{route('design_office.delete_file',['file'=>$files->id])}}">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                    حذف
                                                                </a>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
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
                                </div>
                                <!-- end card body -->
                            </div>
                        </div>
                    @endforeach
                    <div class="tab-pane " id="general_file_panel"
                         role="tabpanel">

                        <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($order->specialties_file->whereIn("type", [5,6,7,8]) as $file)
                                            <div class="col-md-3">
                                                <div class="panel panel-default bootcards-file">

                                                    <div class="list-group">
                                                        <div class="list-group-item d-flex flex-column justify-content-center text-center align-content-center align-items-center">
                                                            <a href="#">
                                                                <i class="fa fa-file-pdf fa-4x"></i>
                                                            </a>
                                                            <h5 class="list-group-item-heading">
                                                                <a href="#">
                                                                    {{$file->real_name}}
                                                                </a>
                                                            </h5>

                                                        </div>
                                                        <div class="list-group-item">
                                                            @if($file->type == 5)
                                                                سلامة ارواح
                                                            @elseif($file->type == 6)
                                                                انذار
                                                            @elseif($file->type == 7)
                                                                اطفاء
                                                            @else
                                                                اخرى
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="panel-footer mt-2">
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-success"
                                                                   href="{{route('design_office.download',['id'=>$file->id])}}">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    تنزيل
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group btn-group-justified">
                                                            <div class="btn-group">
                                                                <a class="btn btn-danger"
                                                                   href="{{route('design_office.delete_file',['file'=>$file->id])}}">
                                                                    <i class="fa fa-trash-alt"></i>
                                                                    حذف
                                                                </a>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                        </div>
                       <div class="card-body">
                           <div class="row">
                               <div class="col-lg-3 col-md-6 col-sm-12">
                                   <div class="form-group">
                                       <label class="col-form-label" for="souls_safety_file">سلامة ارواح</label>
                                       <input type="file" class="form-control" value=""
                                              id="souls_safety_file"
                                              name="souls_safety_file">
                                       <div class="col-12 text-danger" id="souls_safety_file_error"></div>
                                   </div>
                               </div>

                               <div class="col-lg-3 col-md-6 col-sm-12">
                                   <div class="form-group">
                                       <label class="col-form-label" for="warning_file">انذار</label>
                                       <input type="file" class="form-control" value=""
                                              id="warning_file"
                                              name="warning_file">
                                       <div class="col-12 text-danger" id="warning_file_error"></div>
                                   </div>
                               </div>

                               <div class="col-lg-3 col-md-6 col-sm-12">
                                   <div class="form-group">
                                       <label class="col-form-label" for="fire_fighter_file">اطفاء</label>
                                       <input type="file" class="form-control" value=""
                                              id="fire_fighter_file"
                                              name="fire_fighter_file">
                                       <div class="col-12 text-danger" id="fire_fighter_file_error"></div>
                                   </div>
                               </div>

                               <div class="col-lg-3 col-md-6 col-sm-12">
                                   <div class="form-group">
                                       <label class="col-form-label" for="other_file">اخرى</label>
                                       <input type="file" class="form-control" value=""
                                              id="other_file"
                                              name="other_file">
                                       <div class="col-12 text-danger" id="other_file_error"></div>
                                   </div>
                               </div>

                           </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <br>
                <br>
                <br>
                <div class="d-flex flex-wrap gap-3">
                    <button type="button" class="btn btn-lg btn-primary submit_btn">تعديل طلب</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

        @foreach ($specialties as $_specialties)
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
        @endforeach



        $('#add_edit_form').validate({
            rules: {},
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

        $('.submit_btn').click(function (e) {
            $('.req').each((i, e) => {
                $(e).rules("add", {required: true})
            });
            e.preventDefault();

            if (!$("#add_edit_form").valid()) {
                showAlertMessage('error', 'الرجاء ملئ جميع الحقول')

                return false;
            }
            $.ajax({
                url : '{{route('design_office.edit_file_action')}}',
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

                        showAlertMessage('success', data.message);
                        setTimeout(() => {
                            window.location='{{route('design_office.orders')}}';
                        }, "1500")
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
        //    $("#add_edit_form").submit()

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
                    console.log(select_name)
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

        @foreach($specialties as $_specialties)
        @if(isset($order_files[$_specialties->name_en]))

        {{--        file_input_cu('#{{$_specialties->name_en}}_file', {--}}
        {{--            initialPreview: [--}}
        {{--                @foreach($order_files[$_specialties->name_en]->pluck('path')->toArray() as $file)--}}
        {{--                '{{$file}}',--}}
        {{--                @endforeach--}}
        {{--            ]--}}
        {{--        }--}}
        {{--        )--}}
        @endif

        @endforeach
        function file_input_cu(selector, options) {
            let defaults = {
                theme: "fas",//gly
                showDrag: false,
                deleteExtraData: {
                    '_token': '{{csrf_token()}}',
                },

                browseClass: "btn btn-info",
                browseLabel: "اضغط للرفع",
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

        @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_pdf_file')
        @endforeach
        @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_docs_file')
        @endforeach @foreach($specialties as $_specialties)
        file_input_cu('#{{$_specialties->name_en}}_cad_file')
        @endforeach

        file_input_cu('#souls_safety_file')
        file_input_cu('#warning_file')
        file_input_cu('#fire_fighter_file')
        file_input_cu('#other_file')
    </script>

    </script>

@endsection
