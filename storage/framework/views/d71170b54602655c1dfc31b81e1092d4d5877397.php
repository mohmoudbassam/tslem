<?php $__env->startSection('title'); ?>
    المستخدمين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
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

                        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <li class="nav-item">
                                <a class="nav-link px-3 <?php if($loop->first): ?> active <?php endif; ?>" data-bs-toggle="tab"
                                   href="#<?php echo e($_specialties->name_en); ?>"
                                   role="tab"><?php echo e($_specialties->name_ar); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
            <form method="post" action="<?php echo e(route('design_office.save_file')); ?>" id="add_edit_form"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="tab-content">
                    <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane <?php if($loop->first): ?> active <?php endif; ?>" id="<?php echo e($_specialties->name_en); ?>"
                             role="tabpanel">
                            <div class="card">

                                <div class="card-body ">
                                    <div id="<?php echo e($_specialties->name_en); ?>_form_reporter">

                                        <div class="row">
                                            <div data-repeater-list="<?php echo e($_specialties->name_en); ?>">
                                                <div data-repeater-item="" class="mb-2">


                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="service_id">توصيف
                                                                    الخدمة</label>
                                                                <select
                                                                    class="form-select req <?php echo e($_specialties->name_en); ?>_service_id service_id_select"
                                                                    id="service_id"
                                                                    name="service_id">
                                                                    <option value="">اختر...</option>
                                                                    <?php $__currentLoopData = $specialties->where('name_en',$_specialties->name_en)->first()->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option
                                                                            value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <div class="col-12 text-danger service_id_error"
                                                                     id=""></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 ">
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
                                                           for="<?php echo e($_specialties->name_en); ?>_pdf_file">Pdf ملف </label>
                                                    <input type="file"
                                                           class="form-control <?php echo e($_specialties->name_en); ?>_pdf_file"
                                                           id="<?php echo e($_specialties->name_en); ?>_pdf_file"
                                                           name="<?php echo e($_specialties->name_en); ?>_pdf_file">
                                                    <div class="col-12 text-danger"
                                                         id="<?php echo e($_specialties->name_en); ?>_pdf_file"></div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                           for="<?php echo e($_specialties->name_en); ?>_docs_file"> ملف docs</label>
                                                    <input type="file" class="form-control" value=""
                                                           id="<?php echo e($_specialties->name_en); ?>_docs_file"
                                                           name="<?php echo e($_specialties->name_en); ?>_docs_file" multiple>
                                                    <div class="col-12 text-danger"
                                                         id="<?php echo e($_specialties->name_en); ?>_docs_file"></div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                           for="<?php echo e($_specialties->name_en); ?>_cad_file">CAD ملف</label>
                                                    <input type="file" class="form-control" value=""
                                                           id="<?php echo e($_specialties->name_en); ?>_cad_file"
                                                           name="<?php echo e($_specialties->name_en); ?>_cad_file" multiple>
                                                    <div class="col-12 text-danger"
                                                         id="<?php echo e($_specialties->name_en); ?>_cad_error"></div>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </div>


                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">


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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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

                $(element).removeClass("is-invalid");
            }
        });
        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        $('#<?php echo e($_specialties->name_en); ?>_form_reporter').repeater({

            initEmpty: true,

            defaultValues: {
                'text-input': ''
            },

            show: function () {
                var a = document.querySelectorAll('#<?php echo e($_specialties->name_en); ?>_form_reporter');
                a.forEach((e) => {
                    var fileInput = $(this).find('.kartafile');

                    fileInput.fileinput(request_file_input_attributes());

                    var select_service = $(this).find('.<?php echo e($_specialties->name_en); ?>_service_id').on('change', function (e) {

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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        file_input_cu('#general_file')

        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        file_input_cu('#<?php echo e($_specialties->name_en); ?>_pdf_file')

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        file_input_cu('#<?php echo e($_specialties->name_en); ?>_docs_file')

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        file_input_cu('#<?php echo e($_specialties->name_en); ?>_cad_file')

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                url : '<?php echo e(route('design_office.save_file')); ?>',
                data : new FormData($('#add_edit_form').append($('#general_file')).get(0)),
                type: "POST",
                processData: false,
                contentType: false,
                beforeSend(){
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'مكتب تصميم'
                    });
                },
                success:function(data) {
                    if (data.success) {
                        $('#page_modal').modal('hide');

                      window.location='<?php echo e(route('design_office')); ?>'
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
                    '_token': '<?php echo e(csrf_token()); ?>',
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




        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/designer/add_files.blade.php ENDPATH**/ ?>