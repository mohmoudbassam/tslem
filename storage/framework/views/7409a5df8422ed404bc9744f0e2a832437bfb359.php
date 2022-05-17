<?php $__env->startSection('title'); ?>
    المستخدمين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">إضافة مستخدم</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('users')); ?>">المستخدمين</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="card-body p-4">

            <div class="row">
                <form id="add_edit_form" method="get" action="<?php echo e(route('users.get_form')); ?>">

                    <div class="col-lg-12">
                        <div>

                            <div class="mb-3">
                                <label class="form-label" for="type">نوع المستخدم</label>
                                <select class="form-select" id="type" name="type">
                                    <option  value="">اختر...</option>
                                    <option value="service_provider">مقدم خدمة</option>
                                    <option value="design_office">مكتب تصميم</option>
                                    <option value="Sharer">جهة مشاركة</option>
                                    <option value="consulting_office">مكتب استشاري</option>
                                    <option value="contractor">مقاول</option>
                                    <option value="Delivery">تسليم</option>
                                    <option value="Kdana">كدانة</option>
                                </select>
                            </div>
                            <div class="col-12 text-danger" id="type_error"></div>
                        </div>
                    </div>
                </form>
                <br>
                <br>

            </div>
            <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="alert alert-danger" role="alert">
                        <li><?php echo e($error); ?></li>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(session('success')): ?>

                <div class="alert alert-success" role="alert">
                    <li><?php echo e(session('success')); ?></li>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <div style="z-index: 11">
        <div id="toast" class="toast overflow-hidden mt-3 fade hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="align-items-center text-white bg-danger border-0">
                <div class="d-flex">
                    <div class="toast-body">
                        Hello, world! This is a toast message.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>

            $('#type').change(function(e){
                $('#add_edit_form').submit()
            })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedsal/workspace/tslem/resources/views/CP/users/select_form.blade.php ENDPATH**/ ?>