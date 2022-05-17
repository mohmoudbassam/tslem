<?php $__env->startSection('title'); ?>
    تعديل تقرير
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">تعديل تقرير</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('consulting_office')); ?>">المستخدمين</a></li>
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
                        تعديل تقرير
                    </h4>
                </div>

            </div>
        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="<?php echo e(route('consulting_office.edit_report')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="title"></label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo e($report->title); ?>">
                            <div class="col-12 text-danger" id="title_error"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description"></label>
                            <textarea type="text" class="form-control" id="description" name="description">
                                <?php echo e($report->title); ?>

                            </textarea>
                            <div class="col-12 text-danger" id="description_error"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="files">مرفقات</label>
                            <input type="file" class="form-control" multiple id="files" name="files[]">
                            <div class="col-12 text-danger" id="files_error"></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?php echo e($report->id); ?>" name="id">
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
        <?php if($report->attchment->isNotEmpty()): ?>
            file_input('#files',{
                initialPreview: <?php echo json_encode($report->attchment->pluck('file_path')->toArray(), 15, 512) ?>,
                initialPreviewConfig:[
                        <?php $__currentLoopData = $report->attchment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                        caption: '',
                        width: "120px",
                        url: '<?php echo e(route('consulting_office.delete_file',['attchment'=>$file->id])); ?>',
                        key: '<?php echo e($file->id); ?>',
                    },
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ]
            },true);
        <?php else: ?>
        file_input('#files');
        <?php endif; ?>
        $('#add_edit_form').validate({
            rules: {
                "title": {
                    required: true,
                }, "description": {
                    required: true,
                }, "files": {
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



            postData(new FormData($('#add_edit_form').get(0)), '<?php echo e(route('consulting_office.edit_report')); ?>');

        });



    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedsal/workspace/tslem/resources/views/CP/consulting_office/report_edit_form.blade.php ENDPATH**/ ?>