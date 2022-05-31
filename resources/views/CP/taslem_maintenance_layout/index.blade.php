@extends('CP.sharer_layout')
@section('title')
    المواعيد
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"><a class="btn btn-primary" href="{{route('taslem_maintenance.sessions.add_form')}}"><i class="dripicons-user p-2"></i>إصافة موعد</a></h4>

{{--                <div class="page-title-right">--}}
{{--                    <ol class="breadcrumb m-0">--}}
{{--                        <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>--}}
{{--                        <li class="breadcrumb-item active">الرئيسية</li>--}}
{{--                    </ol>--}}
{{--                </div>--}}

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0" id="form_data">

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
                            الاسم
                        </th>
                        <th>
                            تاريخ الموعد
                        </th>
{{--                        <th>--}}
{{--                            الخيارات--}}
{{--                        </th>--}}


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
                    url: '{{route('taslem_maintenance.sessions.list')}}',
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
                    {className: 'text-center', data: 'user.name', name: 'user.name'},
                    {className: 'text-center', data: 'start_at', name: 'start_at'},
                    // {className: 'text-center', data: 'actions', name: 'actions'},

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

        {{--function accept(id) {--}}

        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        url: '{{route('design_office.accept')}}',--}}
        {{--        data: {--}}
        {{--            id: id--}}
        {{--        },--}}
        {{--        type: "POST",--}}

        {{--        beforeSend() {--}}
        {{--            KTApp.block('#page_modal', {--}}
        {{--                overlayColor: '#000000',--}}
        {{--                type: 'v2',--}}
        {{--                state: 'success',--}}
        {{--                message: 'مكتب تصميم'--}}
        {{--            });--}}
        {{--        },--}}
        {{--        success: function (data) {--}}
        {{--            if(data.success){--}}
        {{--                showAlertMessage('success', data.message);--}}
        {{--                $('#items_table').DataTable().ajax.reload(null, false);--}}
        {{--            }else {--}}
        {{--                showAlertMessage('error', 'حدث خطأ في النظام');--}}
        {{--            }--}}

        {{--            KTApp.unblockPage();--}}
        {{--        },--}}
        {{--        error: function (data) {--}}
        {{--            showAlertMessage('error', 'حدث خطأ في النظام');--}}
        {{--            KTApp.unblockPage();--}}
        {{--        },--}}
        {{--    });--}}
        {{--}--}}

        {{--function reject(id) {--}}

        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('design_office.reject') }}',--}}
        {{--        data: {--}}
        {{--            id: id--}}
        {{--        },--}}
        {{--        type: "POST",--}}

        {{--        beforeSend() {--}}
        {{--            KTApp.block('#page_modal', {--}}
        {{--                overlayColor: '#000000',--}}
        {{--                type: 'v2',--}}
        {{--                state: 'success',--}}
        {{--                message: 'مكتب تصميم'--}}
        {{--            });--}}
        {{--        },--}}
        {{--        success: function (data) {--}}
        {{--            if(data.success){--}}
        {{--                showAlertMessage('success', data.message);--}}
        {{--                $('#items_table').DataTable().ajax.reload(null, false);--}}
        {{--            }else {--}}
        {{--                showAlertMessage('error', 'حدث خطأ في النظام');--}}
        {{--            }--}}

        {{--            KTApp.unblockPage();--}}
        {{--        },--}}
        {{--        error: function (data) {--}}
        {{--            showAlertMessage('error', 'حدث خطأ في النظام');--}}
        {{--            KTApp.unblockPage();--}}
        {{--        },--}}
        {{--    });--}}
        {{--}--}}



    </script>

@endsection
