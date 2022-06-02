@extends('CP.master')
@section('title')
    المستخدمين
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
                            الحالة
                        </th>
                        <th>
                            خيارات
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

    <div class="modal  bd-example-modal-lg" id="view-user-files" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="View User Files" aria-hidden="true">
    </div>

    <div class="modal fade" id="view-user-files-modal" tabindex="-1" role="dialog" aria-labelledby="view-user-files-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-user-files-modal-title">مرفقات المستخدم</h5>
                </div>
                <div class="modal-body">
                    <div class="row my-4" id="file-view-row"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-view-files-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-designer-types-modal" tabindex="-1" role="dialog" aria-labelledby="view-user-files-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-designer-types-modal-title">تخصصات المكتب الهندسي</h5>
                </div>
                <div class="modal-body">
                    <div class="row" id="view-designer-types-row">
                        <div class="col-12 d-flex flex-row justify-content-between">
                            <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center" data-type="designer" style="height: 15px; width: 15px;"></div>
                            <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">اشراف</p>
                        </div>
                        <div class="col-12 d-flex flex-row justify-content-between">
                            <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center" data-type="consulting" style="height: 15px; width: 15px;"></div>
                            <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">مكتب تصميم</p>
                        </div>
                        <div class="col-12 d-flex flex-row justify-content-between">
                            <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center" data-type="fire" style="height: 15px; width: 15px;"></div>
                            <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">الحماية والوقاية من الحريق</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-view-designer-types-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
        </div>
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

    <script>
        $(function () {

            $('.select2').select2({
                width: "100%",
            });

            const viewDesignerTypesModal = $("#view-designer-types-modal");

            async function get_design_types(id) {
                let response = await fetch(`/users/${id}/design/types`, {
                    headers: {
                        'accept': 'application/json'
                    },
                });
                return await (await response).json();
            }

            function prepareUserDesignTypesModal(types) {
                let designs = ["consulting", "designer", "fire"];
                types.map((type) => {
                    viewDesignerTypesModal.find(`div[data-type='${type['type']}']`).addClass("bg-success")
                });

                designs.map((design) => {
                    if ( !viewDesignerTypesModal.find(`div[data-type='${design}']`).hasClass("bg-success") ) {
                        viewDesignerTypesModal.find(`div[data-type='${design}']`).addClass("bg-danger")
                    }
                });

            }

            $(document).on("click", ".view-designer-types-btn", async function (event) {
                event.preventDefault();
                let userId = $(this).data("user");
                let response = await get_design_types(userId);
                prepareUserDesignTypesModal(response['data']);
                viewDesignerTypesModal.modal("show");
            });

            $("#close-view-designer-types-modal").on("click", function () {
                viewDesignerTypesModal.modal("hide");
            });

            viewDesignerTypesModal.on('hidden.bs.modal', function (e) {
                let designs = ["consulting", "designer", "fire"];
                designs.map((design) => {
                    viewDesignerTypesModal.find(`div[data-type='${design}']`).removeClass("bg-danger").removeClass("bg-success");
                });
            });

            async function getFiles(id) {
                let response = await fetch(`/users/${id}/files`, {
                    headers: {
                        'accept': 'application/json'
                    },
                });

                return await  (await response).json();
            }

            function prepareViewFiles(data) {
                data.map(file => {
                    $("#file-view-row").append(`<div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view" data-file="${file['path']}" style="cursor:pointer; height: 220px;">
                            <div class="h-100 w-100 rounded border overflow-hidden file-view-wrapper">
                                <div class="file-view-icon" style="background-image: url('${file['icon']}');"></div>
                                <div class="justify-content-center d-flex flex-column text-center border-top" style="height: 40px; background-color: #eeeeee;">
                                    <small class="text-muted" id="file-view-name">${file['name']}</small>
                                </div>
                            </div>
                        </div>`);
                });
            }

            $('#view-user-files-modal').on('hidden.bs.modal', function (e) {
                $("#file-view-row").children().remove();
            });

            $("#close-view-files-modal").on("click", function () {
                $("#view-user-files-modal").modal("hide");
            })

            $(document).on("click", ".file-view", async function (event) {
                event.preventDefault();

                window.open($(this).data("file"));
            });

            $(document).on("click", ".view-files", async function (event) {
                event.preventDefault();
                let userId = $(this).data("user");

                let response = await getFiles(userId);

                if ( response['success'] ) {
                    prepareViewFiles(response['data']);
                    $("#view-user-files-modal").modal("show");
                } else {
                    showAlertMessage('error', response['message']);
                }
            })
        });
    </script>

@endsection
