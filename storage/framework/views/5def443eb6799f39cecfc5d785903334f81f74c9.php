<?php $__env->startSection('title'); ?>
    المستخدمين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء طلب</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('services_providers')); ?>">الطلبات</a></li>
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
                    إنشاء طلب جديد
                </h4>
                </div>


            </div>
        </div>
        <div class="card-body">
          <form id="add_edit_form" method="post" action="<?php echo e(route('services_providers.save_order')); ?>" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div>
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان الطلب</label>
                            <input class="form-control" name="title" type="text" placeholder="العنوان" id="title">
                            <div class="col-12 text-danger" id="title_error"></div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="description" class="form-label">وصف الطلب</label>
                            <textarea class="form-control" name="description"  placeholder="الوصف" id="description"></textarea>
                            <div class="col-12 text-danger" id="description_error"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="mt-3 mt-lg-0">
                        <div class="mb-3">
                            <label for="date" class="form-label">التاريخ</label>
                            <input class="form-control" type="date" name="date" id="date">
                            <div class="col-12 text-danger" id="date_error"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="designer_id">مكتب التصميم</label>
                        <select class="form-select" id="designer_id" name="designer_id">
                            <option  value="">اختر...</option>
                            <?php $__currentLoopData = $designers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option  value="<?php echo e($designer->id); ?>"><?php echo e($designer->company_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-12 text-danger" id="designer_id_error"></div>

                        </select>
                    </div>
                </div>



            </div>

          </form>
            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء طلب</button>
            </div>
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        file_input('#files');
        $('#add_edit_form').validate({
            rules: {
                "title": {
                    required: true,
                },
                "date": {
                    required: true,
                },
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

        $('.submit_btn').click(function (e) {
            e.preventDefault();

            if (!$("#add_edit_form").valid())
                return false;


            $('#add_edit_form').submit()

        });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedsal/workspace/tslem/resources/views/CP/service_providers/create_order.blade.php ENDPATH**/ ?>