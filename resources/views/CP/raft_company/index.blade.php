@extends('CP.master')
@section('title')
    المراكز
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"><a class="btn btn-primary" href="{{route('raft_company.add_center')}}"><i class="dripicons-user p-2"></i>إصافة مركز</a></h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">إدارة المراكز</a></li>
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
                        <div class="col-lg-4">
                            <label class="visually-hidden" for="specificSizeInputName">الاسم او البريد</label>
                            <input type="text" class="form-control" id="name" placeholder="الاسم او البريد">
                        </div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-primary search_btn">بحث</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                           id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;" role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <th>
                            اسم المستخدم
                        </th>
                        <th>
                            البريد الالكتروني
                        </th>
                        <th>
                            الهاتف
                        </th>
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
    <script>
        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "searching": false,
                "processing": true,
                "serverSide": true,
                ajax: {
                    url: "{{route('raft_company.centers_list')}}",
                    type: 'GET',
                    "data": function (d) {
                        d.name = $('#name').val();
                        d.type = $('#type').val();
                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'name', name: 'name',serchable: false,orderable: false},
                    {className: 'text-center', data: 'email', name: 'email',serchable: false,orderable: false},
                    {className: 'text-center', data: 'phone', name: 'phone',serchable: false,orderable: false},
                ],
            });
        });
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });
    </script>

@endsection
