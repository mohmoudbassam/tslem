<?php $__env->startSection('title'); ?>
    الطلبات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">

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

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0">
                        <div class="col-lg-2">
                            <label for="order_id">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_id" placeholder="رقم الطلب">
                        </div>
                        <div class="col-lg-2">
                            <label for="type">مقدم الخدمة</label>
                            <select class="form-control" id="service_provider_id" name="service_provider_id">
                                <option value="">اختر...</option>
                                <?php $__currentLoopData = $services_providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $services_provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($services_provider->id); ?>"><?php echo e($services_provider->company_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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

                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-primary search_btn">بحث</button>
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
                            مقدم الخدمة
                        </th>
                        <th>
                            التاريخ
                        </th>
                        <th>
                            حالة الطلب
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
                    url: '<?php echo e(route('delivery.list')); ?>',
                    type: 'GET',
                    "data": function (d) {
                        d.order_id = $('#order_id').val();
                        d.service_provider_id = $('#service_provider_id').val();
                        d.type = $('#type').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                language: {
                    "url": "<?php echo e(url('/')); ?>/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'title', name: 'title'},
                    {className: 'text-center', data: 'company_name', name: 'service_provider.company_name'},
                    {className: 'text-center', data: 'date', name: 'date'},
                    {className: 'text-center', data: 'order_status', name: 'order_status'},
                    {className: 'text-center', data: 'created_at', name: 'created_at'},
                    {className: 'text-center', data: 'actions', name: 'actions'},

                ],


            });

        });
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });

        function accept(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '<?php echo e(route('delivery.accept')); ?>',
                data: {
                    id: id
                },
                type: "POST",

                beforeSend() {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'جاري الانتظار'
                    });
                },
                success: function (data) {
                    if(data.success){
                        showAlertMessage('success', data.message);
                    }else {
                        showAlertMessage('error', 'حدث خطأ في النظام');
                    }

                    KTApp.unblockPage();
                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                    KTApp.unblockPage();
                },
            });
        }
        function reject(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '<?php echo e(route('delivery.reject')); ?>',
                data: {
                    id: id
                },
                type: "POST",

                beforeSend() {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'جاري الانتظار'
                    });
                },
                success: function (data) {
                    if(data.success){
                        $('#items_table').DataTable().ajax.reload(null, false);
                        showAlertMessage('success', data.message);
                    }else {
                        showAlertMessage('error', 'حدث خطأ في النظام');
                    }

                    KTApp.unblockPage();
                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                    KTApp.unblockPage();
                },
            });
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/delivery/orders.blade.php ENDPATH**/ ?>