@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"><a class="btn btn-primary" href="{{route('users.add')}}"><i class="dripicons-user p-2"></i>إصافة مستخدم</a></h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">إدارة المستخدمين</a></li>
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
                        <div class="col-lg-4">
                            <label class="visually-hidden" for="type"></label>
                            <select class="form-control" id="type" name="type">
                                <option value="">اختر...</option>
                                <option value="admin">مدير نظام</option>
                                <option value="service_provider">شركات حجاج الداخل</option>
                                <option value="design_office">مكتب هندسي</option>
                                <option value="Sharer">جهة مشاركة</option>
                                <option value="consulting_office">مكتب استشاري</option>
                                <option value="contractor">مقاول</option>
                            </select>
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
                        <th>#</th>
                        <th>
                            اسم المستخدم
                        </th>
                        <th>
                            البريد الالكتروني
                        </th>
                        <th>
                            الصلاحيه
                        </th>
                        <th>
                            الهاتف
                        </th>
                        <th>
                            تاريخ التسجيل
                        </th>
                        <th>
                            مفعل/معطل
                        </th>
                        <th>
                            مفعل/معطل
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
    <script src="https://momentjs.com/downloads/moment.js"></script>
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
                    url: '{{route('users.list')}}',
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
                    {className: 'text-center', data: 'id', name: 'id'},
                    {className: 'text-center', data: 'name', name: 'name'},
                    {className: 'text-center', data: 'email', name: 'email'},
                    {className: 'text-center', data: 'type', name: 'type'},
                    {className: 'text-center', data: 'phone', name: 'phone'},
                    {
                        className: 'text-center', data: 'created_at', name: 'date', render: function (data) {
                            return moment(data).format("YYYY-MM-DD hh:mm:ss");
                        }
                    },
                    {className: 'text-center', data: 'enabled', name: 'enabled'},
                    {className: 'text-center', data: 'actions', name: 'actions'},


                ],


            });

        });
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });

        function delete_user(id, url, callback = null) {
            Swal.fire({
                title: 'هل انت متاكد من حذف المستخدم؟',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#84dc61',
                cancelButtonColor: '#d33',
                confirmButtonText: 'تأكيد',
                cancelButtonText: 'لا'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id
                        },
                        beforeSend() {
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                type: 'v2',
                                state: 'success',
                                message: 'الرجاء الانتظار'
                            });
                        },
                        success: function (data) {
                            if (callback && typeof callback === "function") {
                                callback(data);
                            } else {
                                if (data.success) {
                                    $('#items_table').DataTable().ajax.reload(null, false);
                                    showAlertMessage('success', data.message);
                                } else {
                                    showAlertMessage('error', 'هناك خطأ ما');
                                }
                                KTApp.unblockPage();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
                }
            });
        }
    </script>

@endsection
