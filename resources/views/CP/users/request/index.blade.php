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
                            <label class="col-form-label" for="name">البحث</label>
                            <input type="text" class="form-control" id="name" placeholder="البحث">
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label" for="type">فئات المستخدمين</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">اختر...</option>
                                <option value="admin">مدير نظام</option>
                                <option value="service_provider">شركات حجاج الداخل</option>
                                <option value="raft_center">شركات حجاج الخارج</option>
                                <option value="design_office">مكتب هندسي</option>
                                <option value="Sharer">جهة مشاركة</option>
                                <option value="consulting_office">مكتب استشاري</option>
                                <option value="contractor">مقاول</option>
                            </select>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                               id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;" role="grid"
                               aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <th>
                                المستخدم
                            </th>
                            <th>
                                البريد الالكتروني
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
                                الهاتف
                            </th>
                            <th>
                                الحالة
                            </th>
                            <th>
                                الاعتماد
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
    </div>

    <div class="modal fade" id="view-designer-types-modal" tabindex="-1" role="dialog" aria-labelledby="view-user-files-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-designer-types-modal-title">تخصصات المستخدم</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6" id="designer">
                            <div class="row" id="view-designer-types-row">
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1" data-type="designer" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">اشراف</p>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1" data-type="consulting" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">مكتب تصميم</p>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1" data-type="fire" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">الحماية والوقاية من الحريق</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-6" id="contractor">
                            <div class="row" id="view-designer-types-row">
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1" data-type="general" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">عام</p>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1" data-type="protections" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center" style="width: 95%;">الوقاية والحماية من الحرائق</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="close-view-designer-types-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejection-note-modal" tabindex="-1" role="dialog" aria-labelledby="rejection-note" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejection-note-modal-title">ملاحظات رفض الطلب</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('users.request.reject') }}" id="reject-user-form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" value="" name="user_id" id="user_id">
                                    <label class="col-form-label required-field" for="rejection-note">ملاحظات رفض الطلب</label>
                                    <textarea class="form-control mb-1" id="rejection-note" name="rejection_reason" placeholder="ملاحظات رفض الطلب" rows="10" style="resize: none;" required></textarea>
                                    <span class="text-danger" id="rejection-note-error"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" id="submit-rejection-note" class="btn btn-danger" form="reject-user-form" data-dismiss="modal">رفض</button>
                    <button type="button" id="close-rejection-note-modal" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
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
                "autoWidth": false,
                ajax: {
                    url: '{{route('users.request.list')}}',
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
                    {className: 'text-center', data: 'name', name: 'name'},
                    {className: 'text-center', data: 'email', name: 'email'},
                    {className: 'text-center', data: 'license_number', name: 'license_number'},
                    {className: 'text-center', data: 'commercial_record', name: 'commercial_record'},
                    {className: 'text-center', data: 'type', name: 'type'},
                    {className: 'text-center', data: 'phone', name: 'phone'},
                    {className: 'text-center', data: 'enabled', name: 'enabled'},
                    {className: 'text-center', data: 'verified_status', name: 'verified_status'},
                    {className: 'text-center', data: 'actions', name: 'actions'},


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
                                    $('#items_table').DataTable().ajax.reload(null, true);
                                    showAlertMessage('success', data.message);
                                } else {
                                    showAlertMessage('error', 'هناك خطأ ما');
                                }
                                KTApp.unblockPage();
                            }
                        },
                        error: function (data) {
                            // console.log(data);
                        },
                    });
                }
            });
        }


        function accept(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('users.request.accept')}}',
                data: {
                    id: id
                },
                type: "POST",

                beforeSend() {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'الرجاء الانتظار'
                    });
                },
                success: function (data) {
                    if(data.success){
                        $('#items_table').DataTable().ajax.reload(null, true);
                        showAlertMessage('success', data.message);
                    }else {
                        showAlertMessage('error', 'حدث خطأ في النظام');
                    }

                    KTApp.unblockPage();
                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                    KTApp.unblockPage();
                },
            });
        }
        function reject(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            return $.ajax({
                url: '{{route('users.request.reject_form')}}',
                data: {
                    id: id
                },
                type: "POST",

                beforeSend() {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'الرجاء الانتظار'
                    });
                },
                success: function (data) {
                    if(data.success){
                        $('#items_table').DataTable().ajax.reload(null, true);
                        showAlertMessage('success', data.message);
                    }else {
                        showAlertMessage('error', 'حدث خطأ في النظام');
                    }

                    KTApp.unblockPage();
                    return data.success;
                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                    KTApp.unblockPage();
                },
            });
        }
    </script>

    <script>
        $(function () {
            const viewDesignerTypesModal = $("#view-designer-types-modal");

            async function get_design_types(id) {
                let response = await fetch(`/users/${id}/design/types`, {
                    headers: {
                        'accept': 'application/json'
                    },
                });
                return await (await response).json();
            }

            function prepareUserDesignTypesModal(types, userType) {
                let designs = ["consulting", "designer", "fire", "general", "protections"];
                types.map((type) => {
                    viewDesignerTypesModal.find(`div[data-type='${type['type']}']`).addClass("bg-success")
                });

                designs.map((design) => {
                    if ( !viewDesignerTypesModal.find(`div[data-type='${design}']`).hasClass("bg-success") ) {
                        viewDesignerTypesModal.find(`div[data-type='${design}']`).addClass("bg-danger")
                    }
                });

                if ( userType === "design_office" ) {
                    $("#contractor").hide();
                } else {
                    $("#designer").hide();
                }

            }

            $(document).on("click", ".view-designer-types-btn", async function (event) {
                event.preventDefault();
                let userId = $(this).data("user");
                let response = await get_design_types(userId);
                prepareUserDesignTypesModal(response['data'], response['user_type']);
                viewDesignerTypesModal.modal("show");
            });

            $("#close-view-designer-types-modal").on("click", function () {
                viewDesignerTypesModal.modal("hide");
            });

            viewDesignerTypesModal.on('hidden.bs.modal', function (e) {
                let designs = ["consulting", "designer", "fire", "general", "protections"];
                designs.map((design) => {
                    viewDesignerTypesModal.find(`div[data-type='${design}']`).removeClass("bg-danger").removeClass("bg-success");
                });

                $("#designer").show();
                $("#contractor").show();
            });


            let userId = undefined;
            $(document).on("click", ".rejection-user-btn", function (event) {
                event.preventDefault();
                userId = $(this).data("user");
                $("#rejection-note-modal").modal("show");
            });

            $('#rejection-note-modal').on('hidden.bs.modal', function (e) {
                $("#rejection-note").val("");
            });

            $("#close-rejection-note-modal").on("click", function () {
                $("#rejection-note-modal").modal("hide");
            })

            $("#submit-rejection-note").on("click", function (event) {
                event.preventDefault();
                if ( $("#rejection-note-modal").find("textarea").val().length < 1 ) {
                    showAlertMessage("error", "من فضلك اذكر سبب الرفض")
                    return false;
                }

                $("#user_id").val(userId);
                $("#reject-user-form").submit();
            });
        });
    </script>
@endsection
