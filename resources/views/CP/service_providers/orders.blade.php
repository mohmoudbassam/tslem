@extends('CP.master')
@section('title')
    الطلبات
@endsection
@section('content')

    <!-- start page title -->
    @if(auth()->user()->verified)
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    @if($can_create_order)
                        <h4 class="mb-sm-0 font-size-18">
                            <div class="btn-group" role="group">
                                <a href="{{route('services_providers.create_order')}}"
                                   class="btn btn-primary dropdown-toggle">
                                    انشاء الطلب <i class="fa fa-clipboard-check"></i>
                                </a>

                            </div>
                        </h4>
                    @endif

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
                            <li class="breadcrumb-item active">الرئيسية</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0 row-cols-md-4 row-cols-sm-3 row-cols-lg-4 row-cols-2" id="form_data">
                        <div class="col">
                            <label for="order_identifier">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_identifier" placeholder="رقم الطلب">
                        </div>
                        <div class="col">
                            <label for="designer_id">المكتب الهندسي</label>
                            <select class="form-control" id="designer_id" name="designer_id">
                                <option value="">اختر...</option>
                                @foreach($designers as $designer)
                                    <option value="{{$designer->id}}">{{$designer->company_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col">
                            <label for="consulting_id">المشرف</label>
                            <select class="form-control" id="consulting_id" name="consulting_id">
                                <option value="">اختر...</option>
                                @foreach($consulting as $_consulting)
                                    <option value="{{$_consulting->id}}">{{$_consulting->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="contractor_id">المقاول </label>
                            <select class="form-control" id="contractor_id" name="contractor_id">
                                <option value="">اختر...</option>
                                @foreach($contractors as $_contractor)
                                    <option value="{{$_contractor->id}}">{{$_contractor->company_name}}</option>
                                @endforeach
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
                        <!-- <div class="col-sm-auto" style="margin-top:1.9rem;">

                        </div> -->
                        <div class="col-sm-auto ms-auto text-end" style="margin-top:1.9rem;">
                            <button type="button" class="btn btn-primary search_btn px-4 me-2"><i class="fa fa-search me-1"></i>بحث
                            </button>
                            <button type="button" class="btn btn-secondary reset_btn px-4"><i class="fa fa-window-close me-1"></i>إلغاء
                            </button>
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
                            التاريخ
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
                    url: '{{route('services_providers.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.order_identifierentifier = $('#order_identifier').val();
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
                    {className: 'text-right', data: 'identifier', name: 'identifier'},
                    {className: 'text-right', data: 'date', name: 'date', orderable: false},
                    {className: 'text-right', data: 'designer.company_name', name: 'designer', orderable: false},
                    {className: 'text-right', data: 'order_status', name: 'order_status', orderable: false},
                    {className: 'text-right', data: 'contractor.company_name', name: 'contractor', orderable: false},
                    {className: 'text-right', data: 'consulting.company_name', name: 'consulting', orderable: false},
                    {className: 'text-right', data: 'date', name: 'date'},
                    {className: 'text-right', data: 'actions', name: 'actions', orderable: false},
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

@endsection
