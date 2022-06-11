
<?php $__env->startSection('title'); ?>
    الطلبات
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
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0" id="form_data">
                        <div class="col">
                            <label for="order_identifier">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_identifier" placeholder="رقم الطلب">
                        </div>
                        <div class="col">
                            <label for="service_provider_id">شركات حجاج الداخل</label>
                            <select class="form-control" id="service_provider_id" name="service_provider_id">
                                <option value="">اختر...</option>
                                <?php $__currentLoopData = $services_providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $services_provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($services_provider->id); ?>"><?php echo e($services_provider->company_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        <div class="col">
                            <label for="from_date">من </label>
                            <input type="text" class="form-control datepicker" id="from_date" placeholder="">
                        </div>
                        <div class="col">
                            <label for="to_date">الى </label>
                            <input type="text" class="form-control datepicker" id="to_date" placeholder="">
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
                            رقم الطلب
                        </th>
                        <th>
                            مركز ، مؤسسة ، شركة (مطوف)
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
                "searching": true,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '<?php echo e(route('design_office.list')); ?>',
                    type: 'GET',
                    "data": function (d) {
                        d.order_identifier = $('#order_identifier').val();
                        d.service_provider_id = $('#service_provider_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                language: {
                    "url": "<?php echo e(url('/')); ?>/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'identifier', name: 'identifier'},
                    {className: 'text-center', data: 'service_provider.company_name', name: 'company_name',orderable : false},
                    {className: 'text-center', data: 'date', name: 'date'},
                    {className: 'text-center', data: 'order_status', name: 'order_status',orderable : false},
                    {className: 'text-center', data: 'created_at', name: 'created_at',orderable : false},
                    {className: 'text-center', data: 'actions', name: 'actions',orderable : false},

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
        flatpickr(".datepicker");

        

        
        
        
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        

        

        
        
        
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        



    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/designer/orders.blade.php ENDPATH**/ ?>