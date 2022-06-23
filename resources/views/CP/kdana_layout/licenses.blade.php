@extends('CP.kdana_master')
@section('title')
    الاحصائيات
@endsection
@section('style')

@endsection
@section('content')
    <div class="card">

        <!-- region: search -->
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0">
                        <div class="col-lg-4">
                            <label class="visually-hidden" for="specificSizeInputName">البحث</label>
                            <input type="text" class="form-control" id="name" placeholder="البحث">
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
                        @foreach(\App\Models\License::getIndexColumns(true) as $field)
                            <th>{{$field}}</th>
                        @endforeach

                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>
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
                    url: '{{route('kdana.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.name = $('#name').val();
                    },
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json",
                },
                columns: {!! \App\Models\License::getDatatableColumns(true, true) !!}
            })
                .order([0, 'desc']);

        });
        $('#name').keypress(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault()
                submitSearch()
                return false
            } else if (this.value.length >= 2) {
                submitSearch()
            }
        });

@endsection
