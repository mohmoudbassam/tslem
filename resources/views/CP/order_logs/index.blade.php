@extends('CP.master')
@section('title')
    {{\App\Models\OrderLogs::trans('plural')}}
@endsection
@section('content')
    <!-- region: breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{\App\Models\OrderLogs::crudTrans('index')}}</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- endregion: breadcrumb -->

    <!-- region: data -->
    <div class="card">

        <!-- region: search -->
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0 form-search">
                        <div class="col-lg-4 col-sm-12">
                            <label class="visually-hidden" for="name">البحث</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="البحث">
                        </div>

                        <div class="col-lg-1 col-sm-12">
                            <label class="visually-hidden" for="created_at">تاريخ الحركة</label>
                            <input
                                type="text"
                                class="form-control datepicker"
                                name="created_at"
                                id="created_at"
                                placeholder="تاريخ الحركة"
                            >
                        </div>

                        <div class="col-lg-3 col-sm-12">
                            <label class="visually-hidden" for="type">نوع الحركة</label>
                            <select class="form-control form-select" data-trigger id="type" name="type">
                                <option value="">اختر نوع الحركة...</option>
                                @foreach($types as $value=>$label)
                                    <option
                                        value="{{$value}}">{{$label}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <label class="visually-hidden" for="user_id">المستخدم</label>
                            <select class="form-control form-select" data-trigger id="user_id" name="user_id">
                                <option value="">اختر مستخدم...</option>
                                @foreach($users as $value=>$label)
                                    <option
                                        value="{{$value}}">{{$label}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-auto col-sm-12 ms-auto text-end mt-3" >
                            <button
                                type="button"
                                class="btn btn-primary px-4 me-2"
                                onclick="exportExcel()"
                            >
                                <i class="fa fa-file-excel me-1" ></i>
                                تصدير
                            </button>
                            <button type="button" class="btn btn-danger reset_btn px-4" >
                                <i class="fa fa-times me-1" ></i>
                                إلغاء
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <!-- endregion: search -->

        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <!-- region: datatable -->
                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                           id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                           role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        @foreach(\App\Models\OrderLogs::getIndexColumns(true) as $field)
                            <th>{{$field}}</th>
                        @endforeach

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- endregion: datatable -->
                </div>


            </div>
        </div>
    </div>
    <!-- endregion: data -->
@endsection

@section('scripts')
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
        let submitSearch = () => $('#items_table').DataTable().ajax.reload(null, true);

        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "ordering": true,
                "searching": true,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route('order_logs.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.name = $('#name').val();
                        d.type = $('#type').val();
                        d.user_id = $('#user_id').val();
                        d.created_at = $('#created_at').val();
                    },
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json",
                },
                columns: {!! \App\Models\OrderLogs::getDatatableColumns(true, true) !!}
            })
                .order([0, 'desc']);

        });
        $('#type, #user_id, #created_at ').change(submitSearch);
        $('#name').keypress(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault()
                submitSearch()
                return false
            } else if (this.value.length >= 2) {
                submitSearch()
            }
        });
        $('.reset_btn').click(function (ev) {
            $('.form-search').trigger('reset')
            submitSearch()
        })
        flatpickr('.datepicker')

        function exportExcel () {
            let $order = $('#items_table').DataTable().order()[0]
            let data = [...$('.form-search').serializeArray(), { name: 'order', value: $order}];

            location.href = "{{route('order_logs.export')}}?" + $.param(data);
        }
    </script>
@endsection
