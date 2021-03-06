@extends('CP.master')
@section('title')
    التقارير
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">عرض التقارير</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('consulting_office') }}">الطلبات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
{{--        <div class="card-header">--}}
{{--            <div class="row mt-4">--}}
{{--                <div class="col-lg-12">--}}

{{--                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0">--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <label class="visually-hidden" for="specificSizeInputName">الاسم او البريد</label>--}}
{{--                            <input type="text" class="form-control" id="name" placeholder="الاسم او البريد">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <label class="visually-hidden" for="type"></label>--}}
{{--                            <select class="form-control" id="type" name="type">--}}
{{--                                <option value="">اختر...</option>--}}
{{--                                <option value="admin">مدير نظام</option>--}}
{{--                                <option value="service_provider">مقدم خدمة</option>--}}
{{--                                <option value="design_office">مكتب تصميم</option>--}}
{{--                                <option value="Sharer">جهة مشاركة</option>--}}
{{--                                <option value="consulting_office">مكتب استشاري</option>--}}
{{--                                <option value="contractor">مقاول</option>--}}
{{--                                <option value="Delivery">تسليم</option>--}}
{{--                                <option value="Kdana">كدانة</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <div class="col-sm-auto">--}}
{{--                            <button type="button" class="btn btn-primary search_btn">بحث</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}


{{--            </div>--}}
{{--        </div>--}}
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                           id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                           role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <th>
                            عنوان التقرير
                        </th>
                        <th>
                            وصف التقرير
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
                    url: '{{route('consulting_office.reports_list', ['order' => $order->id])}}',
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
                    {className: 'text-center', data: 'title', name: 'title'},
                    {className: 'text-center', data: 'description', name: 'description'},
                    {className: 'text-center space-nowrap', data: 'created_at', name: 'created_at'},
                    {className: 'text-center', data: 'actions', name: 'actions'},

                ],


            });

        });
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });

        function deleteReport(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('consulting_office.delete_report')}}?id=' + id,
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
                    if(data.success){
                        showAlertMessage('success', data.message);
                    }else {
                        showAlertMessage('error', 'حدث خطأ في النظام');
                    }

                    $('#items_table').DataTable().ajax.reload(null, false);

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
