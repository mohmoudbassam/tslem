@extends('CP.sharer_layout')
@section('title')
    المواعيد
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('taslem_maintenance.index')}}">الرئيسية</a></li>
                                    <li class="breadcrumb-item active"><a href="{{route('taslem_maintenance.index')}}">إضافة
                                            موعد</a></li>
                                </ol>
                            </div>

                        </div>
                        <!-- end card body -->
                    </div>

                </div>
            </div>
        </div>
        <div class="card">

            <div class="card-header">
                <div class="row">
                    <div class="col-lg-3 col-xxl-2">
                        <label for="camp_number">رقم المربع </label>
                        <input type="text" class="form-control" name="box_number" id="box_number">
                    </div>
                    <div class="col-lg-3 col-xxl-2">
                        <label for="box_number">رقم المخيم</label>
                        <input type="text" class="form-control" name="camp_number" id="camp_number">
                    </div>
                    <div class="col-auto ms-auto" style="margin-top:1.9rem;">
                        <button type="submit" class="btn btn-primary search_btn"><i class="fa fa-search"></i></button>
                    </div>

                </div>
            </div>

            <div class="card-body pb-0">

                <form id="add_edit_form" method="post" action="{{route('taslem_maintenance.sessions.save')}}"
                      enctype="multipart/form-data">
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
                                البريد الالكتروني
                            </th>
                            <th>
                                اسم المفوض
                            </th>
                            <th>
                                اختيار
                            </th>


                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    @csrf
                    <div class="card-body  border-top d-none" id="view_table">
                        <div class="table-responsive">

                        </div>
                    </div>
                </form>
            </div>
            <div class="row">

                <div class="row text-center">
                    <div class="col-sm-4">
                        <div class="my-4">
                            <button id="add_session" type="button"   class="btn btn-primary waves-effect waves-light">إصافة </button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="my-4">
                            <button type="button"   class="btn btn-primary waves-effect waves-light submit_btn">إنشاء </button>
                        </div>
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
                let selectedItem = []
                $('#add_session').click(function (e) {
                    e.preventDefault();
                    selectedItem = [];
                    if ($('.user_id:checkbox:checked').length) {
                        $('.user_id:checkbox:checked').each(function (i) {
                            selectedItem.push($(this).val())
                        });

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        let url = '{{route('taslem_maintenance.sessions.getTable',':ids')}}';
                        url = url.replace(':ids', selectedItem)
                        console.log(url)
                        $.ajax({
                            url: url,
                            data: {},
                            type: "GET",
                            processData: false,
                            contentType: false,
                            beforeSend() {
                                KTApp.block('#page_modal', {
                                    overlayColor: '#000000',
                                    type: 'v2',
                                    state: 'success',
                                    message: 'مكتب تصميم'
                                });
                            },
                            success: function (data) {
                                $('#view_table').removeClass('d-none')
                                $('#view_table').html(data.page);
                                KTApp.unblockPage();
                            },
                            error: function (data) {
                                console.log(data);
                                KTApp.unblock('#page_modal');
                                KTApp.unblockPage();
                            },
                        });
                    }
                })

                $.fn.dataTable.ext.errMode = 'none';
                $(function () {
                    $('#items_table').DataTable({
                        "dom": 'tpi',
                        "searching": false,
                        "processing": true,
                        'stateSave': true,
                        "serverSide": true,
                        ajax: {
                            url: '{{route('taslem_maintenance.sessions.users_list')}}',
                            type: 'GET',
                            "data": function (d) {
                                d.camp_number = $('#camp_number').val();
                                d.box_number = $('#box_number').val();
                            }
                        },
                        language: {
                            "url": "{{url('/')}}/assets/datatables/Arabic.json"
                        },
                        columns: [
                            {className: 'text-center', data: 'company_name', name: 'company_name'},
                            {className: 'text-center', data: 'email', name: 'email'},
                            {className: 'text-center', data: 'company_owner_name', name: 'company_owner_name'},
                            {className: 'text-center', data: 'actions', name: 'actions'},
                        ],
                    });

                });
                $('.search_btn').click(function (ev) {
                    $('#items_table').DataTable().ajax.reload(null, false);
                });

                $('#add_edit_form').validate({
                    rules: {
                        "start_at": {
                            required: true,
                        }, "user_id": {
                            required: true,
                        }
                    },
                    errorElement: 'span',
                    errorClass: 'help-block help-block-error',
                    focusInvalid: true,
                    errorPlacement: function (error, element) {
                        $(element).addClass("is-invalid");
                        console.log('#' + $(element).attr('id') + '_error')
                        error.appendTo('#' + $(element).attr('id') + '_error');
                    },
                    success: function (label, element) {

                        $(element).removeClass("is-invalid");
                    }
                });

                $('.submit_btn').click(function (e) {
                    e.preventDefault();
                    $('.datepic').each(function() {
                        $(this).rules('add', {
                            required: true,


                        });
                    });

                    if (!$("#add_edit_form").valid())
                        return false;

                    const formData = new FormData();
                    // $('.user_id:checkbox:checked').each(function (i) {
                    //     selectedItem.push($(this).val())
                    // });

                    if (!$('.user_id:checkbox:checked').length) {

                        showAlertMessage('error', 'الرجاء اختيار المستخدم')
                        return false;
                    }
                    {{--formData.append("start_at", $('#start_at').val());--}}
                    {{--formData.append("user_id", $("input:radio.user_id:checked").val());--}}
                    {{--formData.append("_token", '{{ csrf_token() }}');--}}

                    postData(new FormData($('#add_edit_form').get(0)), '{{route('taslem_maintenance.sessions.save')}}');
                });




            </script>

@endsection
