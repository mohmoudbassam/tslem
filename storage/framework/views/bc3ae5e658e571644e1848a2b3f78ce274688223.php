<?php $__env->startSection('title'); ?>
    الطلبات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .close {
            color: #fff !important;
            visibility: hidden !important;
        }

        .file-caption-main {
            color: #fff !important;
            visibility: hidden !important;
        }

        .krajee-default.file-preview-frame {
            margin: 8px;
            border: 1px solid rgba(0, 0, 0, .2);
            box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
            padding: 6px;
            float: left;
            width: 50%;
            text-align: center;
        }

        file-drop-zone clearfix {

        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <h2> مقدم الخدمة :<?php echo e($order->service_provider->name); ?></h2>
            </div>
        </div>
        <div class="card-body">

            <div class="row">

                <?php $__currentLoopData = $order_specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title"><?php echo e($_specialties[0]->service->specialties->name_ar); ?></h4>

                        </div>

                        <div class="card-body">
                            <?php $__currentLoopData = $_specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="service_id">توصيف
                                                    الخدمة</label>
                                                <input type="text" disabled name="" id="" class="form-control req "
                                                       value="<?php echo e($service->service->name); ?>"
                                                       placeholder="">

                                            </div>
                                        </div>

                                        <?php $__currentLoopData = $service->order_service_file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <div class="col-md-3" >
                                              <span class="">
                                                   <label class="form-label" for="service_id"><?php echo e($file->file_type->name_ar); ?></label>

                                                <a class="btn btn-secondary" href="<?php echo e(route('design_office.download',['id'=>$file->id])); ?>" > <i class="fa fa-download fa-4x" style="width:150px ; height:50px"></i></a>
                                              </span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-3 ">
                                            <div class="mb-3 unit_hide">
                                                <label
                                                    class="form-label"><?php echo e($service->service->unit); ?></label>
                                                <input type="text" disabled name="" id="" class="form-control req "
                                                       value="<?php echo e($service->unit); ?>"
                                                       placeholder="">
                                                <div class="col-12 text-danger"
                                                     id="service_id_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        <?php $__currentLoopData = $order_specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_specialties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $_specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $service->order_service_file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        $("#file_<?php echo e($file->id); ?>").fileinput({
            theme: "fa",
            uploadUrl: "/file-upload-batch/2",
            initialPreview: ['<?php echo e($file->path); ?>'],
            minImageWidth: 20,
            minImageHeight: 20,
            maxImageWidth: 70,
            maxImageHeight: 70,
            hideThumbnailContent: true // hide image, pdf, text or other content in the thumbnail preview,

        });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/designer/view_file.blade.php ENDPATH**/ ?>