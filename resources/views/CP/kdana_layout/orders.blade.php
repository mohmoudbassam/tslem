@extends('CP.kdana_master')
@section('title')
    الاحصائيات
@endsection
@section('style')
    <link href="{{url('/')}}/assets/index_files/all.min.css" rel="stylesheet">
    <!-- plugin css -->
    <link href="{{url('/')}}/assets/index_files/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{url('/')}}/assets/index_files/preloader.min.css" type="text/css">
    <link rel="stylesheet" href="{{url('/')}}/assets/index_files/custom-panel.css" type="text/css">

    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/assets/index_files/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet"
          type="text/css">
    <!-- Icons Css -->
    <link href="{{url('/')}}/assets/index_files/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{url('/')}}/assets/index_files/app-rtl-3.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/assets/index_files/fileinput.min.css" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/assets/index_files/alertify.min.css" rel="stylesheet" type="text/css">

    <!-- alertifyjs default themes  Css -->
    <link href="{{url('/')}}/assets/index_files/default.min.css" rel="stylesheet" type="text/css">

    <script src="{{url('/')}}/assets/index_files/sweetalert2.all.min.js.download"></script>
    <link rel="stylesheet" href="{{url('/')}}/assets/deshboard/style.css">
    <style>
        .modal-backdrop.show {
            display: initial !important;
        }
        .modal-backdrop.fade {
            display: initial !important;
        }
        .file-view-wrapper:hover {
            box-shadow: var(--bs-box-shadow) !important;
        }
        .file-view-icon {
            height: 180px;
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .file-view-wrapper{
            position: relative;
        }
        .file-view-download{
            position: absolute;
            top: 9px;
            left: 11px;
            font-size: 18px;
            color: #0b2473;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <form
                        class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0 row-cols-md-4 row-cols-sm-3 row-cols-lg-4 row-cols-2"
                        id="form_data"
                    >
                        <div class="col">
                            <label for="order_identifier">رقم الطلب</label>
                            <input
                                type="text"
                                class="form-control"
                                id="order_identifier"
                                placeholder="رقم الطلب"
                            >
                        </div>

                        <div class="col">
                            <label for="from_date">من</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                id="from_date"
                                placeholder=""
                            >
                        </div>
                        <div class="col">
                            <label for="to_date">الى</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                id="to_date"
                                placeholder=""
                            >
                        </div>
                        <!-- <div class="col-sm-auto" style="margin-top:1.9rem;">

                        </div> -->
                        <div
                            class="col-sm-auto ms-auto text-end"
                            style="margin-top:1.9rem;"
                        >
                            <button
                                type="button"
                                class="btn btn-primary search_btn px-4 me-2"
                            >
                                <i
                                    class="fa fa-search me-1"
                                ></i>
                                بحث
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger reset_btn px-4"
                            >
                                <i
                                    class="fa fa-times me-1"
                                ></i>
                                إلغاء
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
                        <table
                            class="table align-middle datatable dt-responsive table-check dataTable no-footer"
                            id="items_table"
                            style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                            role="grid"
                            aria-describedby="DataTables_Table_0_info"
                        >
                            <thead>
                            <tr>

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
                                <th>
                                    تحكم
                                </th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div
        class="modal bd-example-modal-lg"
        id="page_modal"
        data-backdrop="static"
        data-keyboard="false"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    ></div>
@endsection

@section('scripts')
         <script>

         $.fn.dataTable.ext.errMode = 'none'
         $(function () {

             $('#items_table').DataTable({
                 'dom': 'tpi',
                 'searching': false,
                 'processing': true,
                 'stateSave': true,
                 'serverSide': true,
                 ajax: {
                     url: '{{route('kdana.orders_list')}}',
                     type: 'GET',
                     'data': function (d) {
                         d.order_identifier = $('#order_identifier').val()
                         d.designer_id = $('#designer_id').val()
                         d.consulting_id = $('#consulting_id').val()
                         d.contractor_id = $('#contractor_id').val()
                         d.from_date = $('#from_date').val()
                         d.to_date = $('#to_date').val()
                         d.waste_contractor = $('#waste_contractor').val()
                         d.waste_contractor = $('#waste_contractor').val()

                     }
                 },
                 language: {
                     'url': "{{url('/')}}/assets/datatables/Arabic.json"
                 },
                 columns: [
                     { className: 'text-right', data: 'identifier', name: 'identifier' },
                     { className: 'text-right', data: 'service_provider.company_name', name: 'service_provider', orderable: false },
                     { className: 'text-right', data: 'designer.company_name', name: 'designer', orderable: false },
                     { className: 'text-right', data: 'order_status', name: 'order_status', orderable: false },
                     { className: 'text-right', data: 'contractor.company_name', name: 'contractor', orderable: false },
                     { className: 'text-right', data: 'consulting.company_name', name: 'consulting', orderable: false },
                     { className: 'text-right', data: 'waste_contractor', name: 'waste_contractor', orderable: false },
                     { className: 'text-right space-nowrap', data: 'date', name: 'date' },
                     { className: 'text-left', data: 'actions', name: 'actions' }

                 ]
             })

         })
         $('.search_btn').click(function (ev) {
             $('#items_table').DataTable().ajax.reload(null, false)
         })
         $('.reset_btn').click(function (ev) {
             $('#form_data').trigger('reset')
             $('#items_table').DataTable().ajax.reload(null, false)
         })
         flatpickr('.datepicker')

     </script>

@endsection
