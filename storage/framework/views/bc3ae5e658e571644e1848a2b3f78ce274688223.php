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

        .details_p {
            font-size: 20px;
        }

        .bold {
            font-weight: bold;
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
            <ul class="nav nav-tabs-custom  border-bottom mb-4" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link px-3 active" data-bs-toggle="tab"
                       href="#details"
                       role="tab">تفاصيل الطلب</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 " data-bs-toggle="tab"
                       href="#notes"
                       role="tab">ملاحظات الجهات المشاركة</a>
                </li>
            </ul>


        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="details"
                 role="tabpanel">
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3 mt-4">
                            <h2>تفاصيل الطلب</h2>
                        </div>
                        <div class="col-md-4 mb-3 mt-4">
                            <p class="details_p"><span class="bold">  التاريخ :</span> <?php echo e($order->created_at); ?></p>
                        </div>

                    <!-- <h2> مقدم الخدمة :<?php echo e($order->service_provider->name); ?></h2> -->
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <p class="details_p"><span class="bold">  رقم الطلب : </span><?php echo e($order->id); ?></p>
                        </div>


                        <div class="col-md-6 mb-3">
                            <p class="details_p"><span class="bold">  العنوان : </span><?php echo e($order->title); ?></p>
                        </div>


                        <div class="col-md-6 mb-3">
                            <p class="details_p"><span
                                    class="bold">اسم مقدم الخدمة :</span> <?php echo e($order->service_provider->name); ?>

                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="details_p"><span class="bold">   التفاصيل : </span><?php echo e($order->description); ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="details_p"><span
                                    class="bold"> اسم مكتب التصميم :  </span><?php echo e($order->designer->name); ?></p>
                        </div>

                        <?php if($order->status == \App\Models\Order::PENDING): ?>
                            <div class="offset-md-9 col-md-3 mb-3">
                                <a class="btn btn-primary"
                                   href="<?php echo e(route('design_office.accept',['order'=>$order->id])); ?>">قبول
                                    الطلب</a>
                                <a class="btn btn-danger"
                                   href="<?php echo e(route('design_office.reject',['order'=>$order->id])); ?>">
                                    رفض الطلب
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
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
                                                        <input type="text" disabled name="" id=""
                                                               class="form-control req "
                                                               value="<?php echo e($service->service->name); ?>"
                                                               placeholder="">

                                                    </div>
                                                </div>


                                                <div class="col-md-3 ">
                                                    <div class="mb-3 unit_hide">
                                                        <label
                                                            class="form-label"><?php echo e($service->service->unit); ?></label>
                                                        <input type="text" disabled name="" id=""
                                                               class="form-control req "
                                                               value="<?php echo e($service->unit); ?>"
                                                               placeholder="">
                                                        <div class="col-12 text-danger"
                                                             id="service_id_error"></div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <?php if(!$loop->last): ?>
                                            <hr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row mt-5">
                                        <?php $__currentLoopData = $filess->where('specialties.name_en',$_specialties[0]->service->specialties->name_en); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php if($files->type ==1): ?>
                                                <div class="col-md-offset-3 col-md-2">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item">
                                                                <a href="#">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </a>
                                                                <h5 class="list-group-item-heading">
                                                                    <a href="<?php echo e(route('design_office.download',['id'=>$files->id])); ?>">
                                                                        <?php echo e($files->real_name); ?>

                                                                    </a>
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item">
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-success"
                                                                       href="<?php echo e(route('design_office.download',['id'=>$files->id])); ?>">
                                                                        <i class="fa fa-arrow-down"></i>
                                                                        تنزيل
                                                                    </a>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($files->type ==2): ?>
                                                <div class="col-md-offset-3 col-md-2">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item">
                                                                <a href="<?php echo e(route('design_office.download',['id'=>$files->id])); ?>">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </a>
                                                                <h5 class="list-group-item-heading">
                                                                    <a href="#">
                                                                        <?php echo e($files->real_name); ?>

                                                                    </a>
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item">
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-success"
                                                                       href="<?php echo e(route('design_office.download',['id'=>$files->id])); ?>">
                                                                        <i class="fa fa-arrow-down"></i>
                                                                        تنزيل
                                                                    </a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($files->type ==3): ?>
                                                <div class="col-md-offset-3 col-md-2">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item">
                                                                <a href="#">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </a>
                                                                <h5 class="list-group-item-heading">
                                                                    <a href="#">
                                                                        <?php echo e($files->real_name); ?>

                                                                    </a>
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item">
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-success"
                                                                       href="<?php echo e(route('design_office.download',['id'=>$files->id])); ?>">
                                                                        <i class="fa fa-arrow-down"></i>
                                                                        تنزيل
                                                                    </a>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        
                        
                        
                        
                        
                    </div>
                </div>
            </div>

            <div class="tab-pane active" id="notes"
                 role="tabpanel">
                <div class="card-body">
                    <ul>

                        <?php if($last_note): ?>
                            <?php $__currentLoopData = $last_note; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(preg_match('/\S/', $note)): ?>
                                    <li class="h4"> <?php echo e($note); ?></li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>

                </div>
            </div>

        </div>


    </div>


<?php $__env->stopSection(); ?>




<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/designer/view_file.blade.php ENDPATH**/ ?>