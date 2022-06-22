@extends('CP.master')
@section('title')
    الطلبات
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">

                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">الرئيسية</li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
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
                        <div class="col-12 ms-auto text-end mb-2">
                            <button type="button" class="btn btn-primary search_btn px-4 me-2"><i class="fa fa-search me-1"></i>بحث
                            </button>
                            <button type="button" class="btn btn-primary  px-4 me-2" onclick="exportExcel()"><i
                                    class="fa fa-file-excel me-1" ></i>تصدير
                            </button>
                            <button type="button" class="btn btn-danger reset_btn px-4"><i class="fa fa-times me-1"></i>إلغاء
                            </button>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="order_identifier">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_identifier" placeholder="رقم الطلب">
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="service_provider_id">مركز الخدمة</label>
                            <select class="form-control" id="service_provider_id" name="service_provider_id">
                                <option value="">اختر...</option>
                                @foreach($services_providers as $services_provider)
                                    <option
                                        value="{{$services_provider->id}}">{{$services_provider->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="designer_id">المكتب الهندسي</label>
                            <select class="form-control" id="designer_id" name="designer_id">
                                <option value="">اختر...</option>
                                @foreach($designers as $designer)
                                    <option value="{{$designer->id}}">{{$designer->company_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="consulting_id">المشرف</label>
                            <select class="form-control" id="consulting_id" name="consulting_id">
                                <option value="">اختر...</option>
                                @foreach($consulting as $_consulting)
                                    <option value="{{$_consulting->id}}">{{$_consulting->company_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="contractor_id">المقاول </label>
                            <select class="form-control" id="contractor_id" name="contractor_id">
                                <option value="">اختر...</option>
                                @foreach($contractors as $_contractor)
                                    <option value="{{$_contractor->id}}">{{$_contractor->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="from_date">من </label>
                            <input type="text" class="form-control datepicker" id="from_date" placeholder="">
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="to_date">الى </label>
                            <input type="text" class="form-control datepicker" id="to_date" placeholder="">
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <label for="order_status">حالة الطلب</label>
                            <select class="form-control" id="order_status" name="order_status">
                                <option value="">اختر...</option>
                                @foreach($orderStatuses as $id => $val)
                                    <option value="{!! $id !!}">{!! $val !!}</option>
                                @endforeach
                            </select>
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
                            مركز الخدمة
                        </th>
                        <th>
                            الشركة
                        </th>
                        <th>
                            المكتب الهندسي
                        </th>
                        <th>
                            المقاول
                        </th>
                        <th>
                            التاريخ
                        </th>
                        <th>
                            حالة الطلب
                        </th>
                        <th style="width:150px">
                            الخيارات
                        </th>


                        </thead>
                        <tbody style="font-size: 13px;">
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

        flatpickr(".datepicker");
        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route('delivery.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.order_identifier = $('#order_identifier').val();
                        d.service_provider_id = $('#service_provider_id').val();
                        d.type = $('#type').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.designer_id = $('#designer_id').val();
                        d.consulting_id = $('#consulting_id').val();
                        d.contractor_id = $('#contractor_id').val();
                        d.order_status = $('#order_status').val();
                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'identifier', name: 'identifier'},
                    {className: 'text-center', data: 'service_provider.company_name', name: 'company_name',orderable : false},
                    {className: 'text-center', data: 'raft_name_only', name: 'raft_name_only',orderable : false},
                    {className: 'text-center', data: 'designer.company_name', name: 'company_name',orderable : false},
                    {className: 'text-right', data: 'contractor.company_name', name: 'contractor', orderable: false},
                    {className: 'text-center space-nowrap', data: 'updated_at', name: 'updated_at',orderable : false},
                    {className: 'text-center', data: 'order_status', name: 'order_status',orderable : false},
                    {className: 'text-center', data: 'actions', name: 'actions',orderable : false},

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
                url: '{{route('delivery.accept')}}',
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
                    if (data.success) {
                        showAlertMessage('success', data.message);
                    } else {
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
                url: '{{route('delivery.reject')}}',
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
                    if (data.success) {
                        $('#items_table').DataTable().ajax.reload(null, false);
                        showAlertMessage('success', data.message);
                    } else {
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
        function exportExcel() {

            var query = {

                type: $('#type').val(),
                order_identifier: $('#order_identifier').val(),
                service_provider_id: $('#service_provider_id').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                designer_id: $('#designer_id').val(),
                consulting_id: $('#consulting_id').val(),
                contractor_id: $('#contractor_id').val(),


            };

            var ExcelUrl = "{{route('delivery.export')}}?" + $.param(query);

            window.location = ExcelUrl;
        }

    </script>

@endsection
