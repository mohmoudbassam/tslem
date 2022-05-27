@extends('CP.sharer_layout')
@section('title')
    الطلبات
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">
                    <h4>الطلبات</h4>
                </h4>

                <div class="page-title-left">

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
                        <div class="col-lg-1">
                            <label for="">من </label>
                            <input type="text" class="form-control datepicker" id="from_date" placeholder="">
                        </div>
                        <div class="col-lg-1">
                            <label for="">الى </label>
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
                            عنوان الطلب
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

@endsection

@section('scripts')
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
                    url: '{{route('Sharer.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.name = $('#name').val();
                        d.type = $('#type').val();
                        d.order_id = $('#order_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();


                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'title', name: 'title'},
                    {className: 'text-center', data: 'service_provider.company_name', name: 'service_provider.company_name'},
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
        $('.reset_btn').click(function (ev) {
            $("#form_data").trigger('reset');
            $('#items_table').DataTable().ajax.reload(null, false);
        });
        flatpickr(".datepicker");
        function accept(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('Sharer.accept')}}',
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
                url: '{{route('Sharer.reject')}}',
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

@endsection
