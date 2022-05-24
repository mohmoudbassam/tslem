<?php $__env->startSection('title'); ?>
    الطلبات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(route('services_providers.create_order')); ?>" class="btn btn-primary dropdown-toggle">
                            انشاء الطلب <i class="fa fa-clipboard-check"></i>
                        </a>

                    </div>
                </h4>

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
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0" id="form_data">
                        <div class="col-lg-2">
                            <label for="order_id">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_id" placeholder="رقم الطلب">
                        </div>
                        <div class="col-lg-2">
                            <label for="type">مكتب التصميم</label>
                            <select class="form-control" id="designer_id" name="designer_id">
                                <option value="">اختر...</option>
                                <?php $__currentLoopData = $designers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($designer->id); ?>"><?php echo e($designer->company_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="type">المكتب الإستشاري</label>
                            <select class="form-control" id="consulting_id" name="consulting_id">
                                <option value="">اختر...</option>
                                <?php $__currentLoopData = $consulting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_consulting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($_consulting->id); ?>"><?php echo e($_consulting->company_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="type">المقاول </label>
                            <select class="form-control" id="contractor_id" name="contractor_id">
                                <option value="">اختر...</option>
                                <?php $__currentLoopData = $contractors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_contractor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($_contractor->id); ?>"><?php echo e($_contractor->company_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-auto" style="margin-top:1.9rem;">
                            <button type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i>بحث</button>
                        </div>
                        <div class="col-sm-auto" style="margin-top:1.9rem;">
                            <button type="button" class="btn btn-secondary reset_btn"><i class="fa fa-window-close"></i>إلغاء</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                           id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                           role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <th>
                            عنوان الطلب
                        </th>

                        <th>
                            التاريخ
                        </th>
                        <th>
                            مكتب التصميم
                        </th>
                        <th>
                            حالة الطلب
                        </th>
                        <th>
                            المقاول
                        </th>
                        <th>
                            المكتب الإستشاري
                        </th>
                        <th>
                            تاريخ الإنشاء
                        </th>
                        <th>
                            الخيارات
                        </th>


                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>


        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '<?php echo e(route('services_providers.list')); ?>',
                    type: 'GET',
                    "data": function (d) {
                        d.order_id = $('#order_id').val();
                        d.designer_id = $('#designer_id').val();
                        d.consulting_id = $('#consulting_id').val();
                        d.contractor_id = $('#contractor_id').val();

                    }
                },
                language: {
                    "url": "<?php echo e(url('/')); ?>/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-right', data: 'title', name: 'title'},
                    {className: 'text-right', data: 'date', name: 'date'},
                    {className: 'text-right', data: 'designer.company_name', name: 'designer'},
                    {className: 'text-right', data: 'order_status', name: 'order_status'},
                    {className: 'text-right', data: 'contractor.company_name', name: 'contractor'},
                    {className: 'text-right', data: 'consulting.company_name', name: 'consulting'},
                    {className: 'text-right', data: 'created_at', name: 'created_at'},
                    {className: 'text-right', data: 'actions', name: 'actions'},


                ],


            });

        });
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });
        $('.reset_btn').click(function (ev) {
            $("#form_data").trigger('reset');
            $('#items_table').DataTable().ajax.reload(null, false);
        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/service_providers/orders.blade.php ENDPATH**/ ?>