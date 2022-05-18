<?php $__env->startSection('title'); ?>
    انشاء خدمة
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء خدمة</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('service.index')); ?>">الخدمات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <h4>
                        تعديل خدمة
                    </h4>
                </div>

            </div>
        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="<?php echo e(route('service.update')); ?>">
                <?php echo csrf_field(); ?>
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">الإسم</label>
                            <input type="text" class="form-control" name="name" value="<?php echo e($service->name); ?>" id="name" placeholder="الإسم">
                            <div class="col-12 text-danger" id="name_error"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="unit">الوحدة</label>
                            <input type="text" class="form-control" name="unit" value="<?php echo e($service->unit); ?>" id="unit" placeholder="الوحدة">
                            <div class="col-12 text-danger" id="unit_error"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label  for="parnet_id">نوع الملف</label>
                            <select class="form-control" id="file_ids" name="file_ids" >



                            </select>
                            <div class="col-12 text-danger" id="file_ids_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">

                            <label  for="parnet_id">تصنيف الملف</label>
                            <select class="form-control" id="specialties_id" name="specialties_id">
                                <option value="">اختر...</option>
                                <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($s->id == $service->specialties_id): ?> selected <?php endif; ?> value="<?php echo e($s->id); ?>"><?php echo e($s->name_ar); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="col-12 text-danger" id="specialties_id_error"></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo e($service->id); ?>" name="id">


                </div>
            </form>

            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn">تعديل</button>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function () {
            const selectedFileTypes = <?php echo json_encode($service->file_type, 15, 512) ?>.map(item =>  item.id);
            $('#file_ids').select2({
                data: <?php echo json_encode( $file_types , 15, 512) ?> .map(item => ({id: item.id, text: item.name_ar})),
                multiple: true,
                placeholder: "اختر ...",
                val: selectedFileTypes,
            });

            $('#file_ids').select2('data', selectedFileTypes);


            console.clear();
            console.log(selectedFileTypes);
            $('#file_ids').val(selectedFileTypes);
        });

        $('#add_edit_form').validate({
            rules: {
                "name": {
                    required: true,
                }, "unit": {
                    required: true,
                }, "file_ids": {

                }, "specialties_id": {
                    required: true,
                }
                
                
                
                
                
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

            const formData = new FormData($('#add_edit_form').get(0));
            formData.delete("file_ids");
            $('#file_ids').val().forEach(id => {
                formData.append("file_ids[]", id);
            });
            postData(formData, '<?php echo e(route('service.update')); ?>');

        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedsal/workspace/tslem/resources/views/CP/SystemConfig/services_update.blade.php ENDPATH**/ ?>