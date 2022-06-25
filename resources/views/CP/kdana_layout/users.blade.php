@extends('CP.kdana_master')
@section('title')
    الاحصائيات
@endsection
@section('style')

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

        .file-view-wrapper {
            position: relative;
        }

        .file-view-download {
            position: absolute;
            top: 9px;
            left: 11px;
            font-size: 18px;
            color: #0b2473;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"><a class="btn btn-primary" href="{{route('users.add')}}"><i
                            class="dripicons-user p-2"></i>إضافة مستخدم</a></h4>

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
            <div class="row mt-4 d-flex ">
                <div class="col-lg-8">

                    <form class="row">
                        <div class="col-lg-4">
                            <label class="col-form-label" for="name">البحث</label>
                            <input type="text" class="form-control" id="name" placeholder="البحث">
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label" for="type">فئات المستخدمين</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">اختر...</option>
                                <option value="admin">مدير نظام</option>
                                <option @if(request('params')=='raft_in') selected @endif  value="service_provider">
                                    شركات
                                    حجاج الداخل
                                </option>
                                <option @if(request('params')=='raft_out') selected @endif value="raft_center">شركات
                                    حجاج
                                    الخارج
                                </option>
                                <option @if(request('params')=='design_office') selected @endif value="design_office">
                                    مكتب
                                    هندسي
                                </option>
                                <option value="Sharer">جهة مشاركة</option>
                                <option value="consulting_office">مكتب استشاري</option>
                                <option @if(request('params')=='contractor') selected @endif  value="contractor">مقاول
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label style="opacity: 0;" class="col-form-label d-block">تصدير</label>
                                <button type="button" onclick="exportExcel()" class="btn btn-primary btn-block">تصدير
                                </button>
                            </div>
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
                        <th>#</th>
                        <th>
                            الشركة
                        </th>
                        <th>
                            شركة الطوافة
                        </th>
                        <th>
                            الترخيص
                        </th>
                        <th>
                            السجل
                        </th>
                        <th>
                            نوع المستخدم
                        </th>
                        <th>
                            تاريخ التسجيل
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
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
        let submitSearch = () => $('#items_table').DataTable().ajax.reload(null, true);

        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route('kdana.users_list')}}',
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
                    {className: 'text-center', data: 'company_name', name: 'company_name'},

                    {className: 'text-center', data: 'license_number', name: 'license_number'},
                    {className: 'text-center', data: 'commercial_record', name: 'commercial_record'},
                    {className: 'text-center', data: 'type', name: 'type'},
                    {
                        className: 'text-center', data: 'created_at', name: 'date', render: function (data) {
                            return moment(data).format("YYYY-MM-DD hh:mm:ss");
                        },searchable:false,orderable:false
                    },


                ],


            });

        });
        $('#type').change(function (e) {
            submitSearch()
        });
        $('#name').keypress(function (e) {
            if( e.keyCode === 13 ) {
                e.preventDefault()
                submitSearch()
                return false
            } else if( this.value.length >= 2 ) {
                submitSearch()
            }
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
                        },
                    });
                }
            });
        }
    </script>

@endsection
