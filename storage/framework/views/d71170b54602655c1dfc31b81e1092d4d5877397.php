<?php $__env->startSection('title'); ?>
    المستخدمين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

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

                        <?php $__currentLoopData = $specialties->where('name_en','!=','electrical'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link px-3 " data-bs-toggle="tab" href="#<?php echo e($_specialties->name_en); ?>"
                                   role="tab"><?php echo e($_specialties->name_ar); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab" href="#electrical" role="tab">الكهربائية</a>
                        </li>
                    </ul>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
            <form method="post" action="<?php echo e(route('design_office.save_file')); ?>" id="add_edit_form"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="tab-content">
                    <?php $__currentLoopData = $specialties->where('name_en','!=','electrical'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane <?php if($loop->first): ?> active <?php endif; ?>"   id="<?php echo e($_specialties->name_en); ?>" role="tabpanel">
                        <div class="card">

                            <div class="card-body ">
                                <div id="<?php echo e($_specialties->name_en); ?>_form_reporter">

                                    <div class="row">
                                        <div data-repeater-list="<?php echo e($_specialties->name_en); ?>">
                                            <div data-repeater-item="" class="mb-2">


                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="service_id">توصيف
                                                                الخدمة</label>
                                                            <select class="form-select req <?php echo e($_specialties->name_en); ?>_service_id"
                                                                    id="service_id"
                                                                    name="service_id">
                                                                <option value="">اختر...</option>
                                                                <?php $__currentLoopData = $specialties->where('name_en',$_specialties->name_en)->first()->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option
                                                                        value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-12 text-danger"
                                                                     id="service_id_error"></div>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3 ">
                                                            <label class="form-label" for="formrow-password-input">الخريطة</label>
                                                            <input name="file" type="file" id="file"
                                                                   data-show-preview="false" class="kartafile" multiple>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 ">
                                                        <div class="mb-3 d-none">
                                                            <label class="form-label">العدد/م</label>
                                                            <input type="text" name="unit" class="form-control req"
                                                                   placeholder="العدد">
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                                                                <?php $__currentLoopData = $specialties->where('name_en','electrical')->first()->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option
                                                                        value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


                <div class="d-flex flex-wrap gap-3">
                    <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء طلب</button>
                </div>
            </form>
        </div>
        <!-- end col -->


    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>

        $('#architect_form_reporter').repeater({

            initEmpty: true,

            defaultValues: {
                'text-input': ''
            },

            show: function () {
                var a = document.querySelectorAll('#architect_form_reporter');
                a.forEach((e) => {
                    var fileInput = $(this).find('.kartafile');

                    fileInput.fileinput(request_file_input_attributes());

                    var select_service = $(this).find('.architect_service_id').on('change', function (e) {

                        var url = '<?php echo e(route("design_office.get_service_by_id", ":id")); ?>';
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
        $('#electrical_form_reporter').repeater({

            initEmpty: false,

            defaultValues: {
                'text-input': ''
            },

            show: function () {
                var a = document.querySelectorAll('#architect_form_reporter');
                a.forEach((e) => {
                    //   e.datepicker({});
                    var fileInput = $(this).find('.kartafile');

                    fileInput.fileinput(request_file_input_attributes());

                })
                $(this).slideDown();

            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        $('#construction_form_reporter').repeater({

            initEmpty: false,

            defaultValues: {
                'text-input': ''
            },

            show: function () {
                var a = document.querySelectorAll('#architect_form_reporter');
                a.forEach((e) => {
                    //   e.datepicker({});
                    var fileInput = $(this).find('.kartafile');

                    fileInput.fileinput(request_file_input_attributes());

                })
                $(this).slideDown();

            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        $('#mchanical_form_reporter').repeater({

            initEmpty: false,

            defaultValues: {
                'text-input': ''
            },

            show: function () {
                var a = document.querySelectorAll('#architect_form_reporter');
                a.forEach((e) => {
                    //   e.datepicker({});
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
                error.appendTo('#' + $(element).attr('id') + '_error');
            },
            success: function (label, element) {

                $(element).removeClass("is-invalid");
            }
        });

        function addValidationRule() {

        }

        $('.submit_btn').click(function (e) {
            e.preventDefault();
            new FormData($('#add_edit_form').get(0))
            // if (!$("#add_edit_form").valid())
            //     return false;
            //
            //
            // $('#add_edit_form').submit()
            console.log($("#add_edit_form").valid())
            if (!$("#add_edit_form").valid())
                return false;
            // postData(new FormData($('#add_edit_form').get(0)), ');

        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/designer/add_files.blade.php ENDPATH**/ ?>