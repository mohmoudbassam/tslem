@extends('CP.sharer_layout')
@section('title')
    المواعيد
@endsection
@section('content')
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
    </style>
    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col-lg">
            @if($isToday)
            <h2>مواعيد اليوم</h2>
            @else
            <h2>جميع المواعيد</h2>
            @endif
        </div>
        <div class="col-lg-auto mt-3 mt-lg-0">


            <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                <h4 class="mb-sm-0 font-size-18 me-2"><a class="btn btn-primary" href="{{route('taslem_maintenance.sessions.add_form')}}"><i class="fa fa-plus pe-2"></i>إضافة موعد</a></h4>
                @if(!$isToday)
                <h4 class="mb-sm-0 font-size-18"><a class="btn btn-primary" href="{{route('taslem_maintenance.sessions.toDaySessions')}}"><i class="fa fa-clock pe-2"></i>مواعيد اليوم</a></h4>
                @else
                <h4 class="mb-sm-0 font-size-18"><a class="btn btn-primary" href="{{route('taslem_maintenance.index')}}"><i class="fa fa-clock pe-2"></i>جميع المواعيد</a></h4>
                @endif

            <div class="page-title-box d-sm-flex align-items-center justify-content-end">
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0 " id="form_data">
                    @if(!$isToday)
                        <div class="col-lg-3 col-xxl-2">
                            <label for="">من </label>
                            <input type="text" class="form-control datepicker" id="from_date" placeholder="">
                        </div>
                        <div class="col-lg-3 col-xxl-2">
                            <label for="">الى </label>
                            <input type="text" class="form-control datepicker" id="to_date" placeholder="">
                        </div>
                        @endif

                        <div class="col-sm-auto ms-auto" style="margin-top:1.9rem;">
                            <button type="button" class="btn btn-primary search_btn px-4 me-2"><i class="fa fa-search me-1"></i>بحث</button>

                            <button type="button" class="btn btn-secondary reset_btn px-4"><i class="far fa-times me-1"></i>إلغاء</button>
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
                            اسم شركة الطوافة
                        </th>
                        <th>
                            رقم المربع
                        </th>
                        <th>
                           رقم المخيم
                        </th>
                        <th>
                            وقت الموعد
                        </th>
                        <th>
                            
                        </th>


                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>

    </div>


    <div class="modal fade" id="page_modal" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false" aria-labelledby="view-user-files-modal-title" aria-hidden="true">

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
                    url: '{{route('taslem_maintenance.sessions.list',["list_type" => (($isToday) ? 'today' : 'general')])}}',
                    type: 'GET',
                    "data": function (d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-right', data: 'raft_company_location.name', name: 'raft_company_location.name',orderable : false},
                    {className: 'text-center', data: 'raft_company_box.box', name: 'raft_company_box.box',orderable : false},
                    {className: 'text-center', data: 'raft_company_box.camp', name: 'raft_company_box.camp',orderable : false},
                    {className: 'text-center', data: 'start_at', name: 'start_at'},
                    {className: 'text-left', data: 'actions', name: 'actions'}

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
