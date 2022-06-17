@extends('CP.master')
@section('title')
    الطلبات
@endsection
@section('content')

    <!-- start page title -->

    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <form
                        class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0 row-cols-md-4 row-cols-sm-3 row-cols-lg-4 row-cols-2"
                        id="form_data">
                        <div class="col">
                            <label for="order_identifier">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_identifier" placeholder="رقم الطلب">
                        </div>

                        <div class="col">
                            <label for="from_date">من </label>
                            <input type="text" class="form-control datepicker" id="from_date" placeholder="">
                        </div>
                        <div class="col">
                            <label for="to_date">الى </label>
                            <input type="text" class="form-control datepicker" id="to_date" placeholder="">
                        </div>
                        <!-- <div class="col-sm-auto" style="margin-top:1.9rem;">

                        </div> -->
                        <div class="col-sm-auto ms-auto text-end" style="margin-top:1.9rem;">
                            <button type="button" class="btn btn-primary search_btn px-4 me-2"><i
                                    class="fa fa-search me-1"></i>بحث
                            </button>
                            <button type="button" class="btn btn-primary  px-4 me-2" onclick="exportExcel()"><i
                                    class="fa fa-file-excel me-1" ></i>تصدير
                            </button>
                            <button type="button" class="btn btn-secondary reset_btn px-4"><i
                                    class="fa fa-window-close me-1"></i>إلغاء
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table align-middle datatable dt-responsive table-check dataTable no-footer"
                           id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                           role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <th>
                            رقم الطلب
                        </th>
                        <th>
                            مركز الخدمة
                        </th>
                        <th>
                            المكتب الهندسي
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
                            مقاول النفايات
                        </th>
                        <th>
                            تاريخ الإنشاء
                        </th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>


            </div>
        </div>

    </div>

    <div class="modal bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>


    @if(is_null(auth()->user()->license_number) and auth()->user()->type == "service_provider" and is_null(auth()->user()->parent_id))
        <div class="modal fade" id="licence-number-modal" tabindex="-1" role="dialog"
             aria-labelledby="licence-number-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="licence-number-modal-title">إضافة رقم الترخيص</h5>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('services_providers.update_licence_number') }}"
                              id="update-licence-number-form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label required-field" for="licence-number">رقم
                                            الترخيص</label>
                                        <input type="number" class="form-control" name="license_number"
                                               id="licence-number" placeholder="رقم الترخيص" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" id="submit-licence-number" form="update-licence-number-form"
                                class="btn btn-primary" data-dismiss="modal">موافق
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                    url: '{{route('orders.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.order_identifierentifier = $('#order_identifier').val();
                        d.designer_id = $('#designer_id').val();
                        d.consulting_id = $('#consulting_id').val();
                        d.contractor_id = $('#contractor_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.waste_contractor = $('#waste_contractor').val();
                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-right', data: 'identifier', name: 'identifier'},
                    {className: 'text-right', data: 'service_provider.company_name', name: 'service_provider', orderable: false},
                    {className: 'text-right', data: 'designer.company_name', name: 'designer', orderable: false},
                    {className: 'text-right', data: 'order_status', name: 'order_status', orderable: false},
                    {className: 'text-right', data: 'contractor.company_name', name: 'contractor', orderable: false},
                    {className: 'text-right', data: 'consulting.company_name', name: 'consulting', orderable: false},
                    {className: 'text-right', data: 'waste_contractor', name: 'waste_contractor', orderable: false},
                    {className: 'text-right', data: 'date', name: 'date'},

                ]
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

    <script>
        function exportExcel() {

            var query = {

                type: $('#type').val(),

            };

            var ExcelUrl = "{{route('orders.export')}}?" + $.param(query);

            window.location = ExcelUrl;
        }

        $(function () {
            $("#licence-number-modal").modal({backdrop: 'static', keyboard: false});
            $("#licence-number-modal").modal("show", {backdrop: 'static', keyboard: false});
        });
    </script>
@endsection
