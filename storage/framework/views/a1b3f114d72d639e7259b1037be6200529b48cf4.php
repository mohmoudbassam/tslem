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
                                        <h2 class="font-size-16">تعديل الطلب</h2>

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


                                <div class="card-body">
                                    <?php if(isset($order_specialties[$_specialties->name_en])): ?>

                                        <?php $__currentLoopData = $order_specialties[$_specialties->name_en]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_services): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="service_id">توصيف
                                                                الخدمة</label>
                                                            <select
                                                                class="form-select req"
                                                                id="service_id"
                                                                name="service_id">

                                                                <?php $__currentLoopData = $system_specialties_services->where('name_en','architect')->first()->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $services): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($services->id); ?>"
                                                                            <?php if($services->id == $_services->id): ?> selected <?php endif; ?>><?php echo e($services->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            </select>
                                                            <div class="col-12 text-danger"
                                                                 id="_error"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="mb-3 unit_hide">
                                                            <label
                                                                class="form-label"><?php echo e($_services->service->unit); ?></label>
                                                            <input type="text" name="unit" value="<?php echo e($_services->unit); ?>"
                                                                   class="form-control req"
                                                                   placeholder="">
                                                            <div class="col-12 text-danger"
                                                                 id="service_id_error"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <div id="<?php echo e($_specialties->name_en); ?>_form_reporter">

                                        <div class="row">

                                            <div data-repeater-list="<?php echo e($_specialties); ?>">
                                                <div data-repeater-item="" class="mb-2">


                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="service_id">توصيف
                                                                    الخدمة</label>
                                                                <select
                                                                    class="form-select req"
                                                                    id="service_id"
                                                                    name="service_id">
                                                                    <option value="">اختر...</option>
                                                                    <?php $__currentLoopData = $specialties->where('name_en',$_specialties->name_en)->first()->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option
                                                                            value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <div class="col-12 text-danger"
                                                                     id="_error"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 ">
                                                            <div class="mb-3 unit_hide">
                                                                <label class="form-label">عدد</label>
                                                                <input type="text" name="unit" class="form-control req"
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="row mb-6">
                    <div class="col-md-offset-3 col-md-2">
                        <div class="panel panel-default bootcards-file">

                            <div class="list-group">
                                <div class="list-group-item">
                                    <a href="#">
                                        <i class="fa fa-file fa-4x"></i>
                                    </a>
                                    <h5 class="list-group-item-heading">
                                        <a href="#">
                                            file name
                                        </a>
                                    </h5>

                                </div>
                                <div class="list-group-item">
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button class="btn btn-success">
                                            <i class="fa fa-arrow-down"></i>
                                            Download
                                        </button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-offset-3 col-md-2">
                        <div class="panel panel-default bootcards-file">

                            <div class="list-group">
                                <div class="list-group-item">
                                    <a href="#">
                                        <i class="fa fa-file fa-4x"></i>
                                    </a>
                                    <h5 class="list-group-item-heading">
                                        <a href="#">
                                            file name
                                        </a>
                                    </h5>

                                </div>
                                <div class="list-group-item">
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button class="btn btn-success">
                                            <i class="fa fa-arrow-down"></i>
                                            Download
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash-alt"></i>
                                            delete
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                <br>
                <br>
                <br>
                <div class="d-flex flex-wrap gap-3">
                    <button type="button" class="btn btn-lg btn-primary submit_btn">تعديل طلب</button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>

        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        var repeater = $('#<?php echo e($_specialties->name_en); ?>_form_reporter').repeater({

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

        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isset($order_files[$_specialties->name_en])): ?>

        
        
        
        
        
        
        
        
        <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    </script>

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/designer/edit_files.blade.php ENDPATH**/ ?>