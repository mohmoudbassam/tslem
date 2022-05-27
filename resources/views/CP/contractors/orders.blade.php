@extends('CP.master')
@section('title')
    الطلبات
@endsection
@section('content')

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

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0">
                        <div class="col-lg-2">
                            <label for="order_id">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_id" placeholder="رقم الطلب">
                        </div>


                        <div class="col-lg-2">
                            <label for="type"> مؤسسة ، شركة (مطوف)</label>
                            <select class="form-control" id="service_provider_id" name="service_provider_id">
                                <option value="">اختر...</option>
                                @foreach($service_providers as $services_provider)
                                    <option value="{{$services_provider->id}}">{{$services_provider->company_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="type"> المكتب الهندسي</label>
                            <select class="form-control" id="designer_id" name="designer_id">
                                <option value="">اختر...</option>
                                @foreach($designers as $designer)
                                    <option value="{{$designer->id}}">{{$designer->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="type">المشرف</label>
                            <select class="form-control" id="consulting_id" name="consulting_id">
                                <option value="">اختر...</option>
                                @foreach($consulting as $_consulting)
                                    <option value="{{$_consulting->id}}">{{$_consulting->company_name}}</option>
                                @endforeach

                            </select>
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
                            مقدم الخدمة
                        </th>
                        <th>
                           مكتب التصميم
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
                    url: '{{route('contractor.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.order_id = $('#order_id').val();
                        d.designer_id = $('#designer_id').val();
                        d.consulting_id = $('#consulting_id').val();
                        d.contractor_id = $('#contractor_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();

                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'title', name: 'title'},
                    {className: 'text-center', data: 'service_provider.company_name', name: 'company_name'},
                    {className: 'text-center', data: 'designer.company_name', name: 'company_name'},
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
        flatpickr(".datepicker");
        function accept(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '',
                data: {
                    id: id
                },
                type: "POST",

                beforeSend() {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'مكتب تصميم'
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



    </script>

@endsection
