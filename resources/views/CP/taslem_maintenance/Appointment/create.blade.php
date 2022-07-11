@extends('CP.master')

@section('title', trans_choice('choice.Appointments', 2) )

@section('style')
    <link
        href="{{url('/assets/libs/choices.js/public/assets/styles/choices.min.css')}}"
        rel="stylesheet"
        type="text/css"
    />
@stop

@section('content')
    <!-- start page title -->
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">
                                الرئيسية
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('taslem_maintenance.Appointment.index')}}">
                                    {{ trans_choice('choice.Appointments', 2) }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                إضافة موعد
                            </li>
                        </ol>
                    </div>

                </div>
                <!-- end card body -->
            </div>
            <div class="card">

                <div class="card-header">
                    <form
                        id="add_edit_form"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        <div class="row">
                            <div class="col-lg col-xxl">
                                <label
                                    class="form-label"
                                    for="service_provider_id"
                                >
                                    مركز الخدمة
                                </label>
                                <select
                                    class="form-control"
                                    data-trigger
                                    id="service_provider_id"
                                    name="service_provider_id"
                                >
                                    <option
                                        value=""
                                        selected
                                    >أختر
                                    </option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{$user->company_name}}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="col-12 text-danger"
                                    id="box_number_error"
                                ></div>
                            </div>
                            <div class="col-lg col-xxl service-provider">
                                <label
                                    class="form-label"
                                    for="box_number"
                                >رقم المربع
                                    <span
                                        class="text-danger required-mark"
                                    >*
                                    </span>
                                </label>
                                <select
                                    class="form-control"
                                    data-trigger
                                    id="box_number"
                                    name="box_number"
                                >
                                    <option
                                        value=""
                                        selected
                                    >أختر
                                    </option>
                                    @foreach($boxes as $box)
                                        <option value="{{ $box['box'] }}">{{$box['box']}}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="col-12 text-danger"
                                    id="box_number_error"
                                ></div>
                            </div>
                            <div class="col-lg col-xxl service-provider">
                                <label
                                    class="form-label"
                                    for="camp_number"
                                >رقم المخيم
                                    <span
                                        class="text-danger required-mark"
                                    >*
                                    </span>
                                </label>
                                <select
                                    class="form-control"
                                    disabled
                                    id="camp_number"
                                    name="camp_number"
                                >
                                    <option value=""></option>
                                </select>
                                <div
                                    class="col-12 text-danger"
                                    id="camp_number_error"
                                ></div>
                            </div>
                            <div class="col-lg col-xxl">
                                <label for="start_at">وقت الموعد
                                    <span
                                        class="text-danger required-mark"
                                    >*
                                    </span>
                                </label>
                                <div class="input-group auth-pass-inputgroup">

                                    <input
                                        type="text"
                                        class="form-control datepicker"
                                        data-enabletime="true"
                                        id="start_at"
                                        name="start_at"
                                    >

                                    <div class="btn btn-light shadow-none ms-0">
                                        <i class="far fa-clock"></i>
                                    </div>
                                </div>
                                <div
                                    class="col-12 text-danger"
                                    id="start_at_error"
                                ></div>
                            </div>
                        </div>
                        <div class="row">
                        </div>
                        <div class="row">
                            <div
                                class="col-auto ms-auto"
                                style="margin-top:1.9rem;"
                            >
                                <button
                                    type="button"
                                    class="btn btn-primary  px-4 submit_btn"
                                >اضافة الى قائمة
                                    المواعيد
                                </button>
                                <!-- <button type="submit" class="btn btn-primary search_btn"><i class="fa fa-search"></i></button> -->
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>

                <div class="card-body pb-0">
                    <h4 class="mt-2 mb-4 text-center">قائمة المواعيد</h4>

                    <div class="col-sm-12">
                        <table
                            class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                            id="items_table"
                            style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                            role="grid"
                            aria-describedby="DataTables_Table_0_info"
                        >
                            <thead>
                            <tr>
                                <th>
                                    مركز الخدمة
                                </th>
                                <th>
                                    اسم الشركة
                                </th>
                                <th>
                                    رقم المربع
                                </th>
                                <th>
                                    رقم المخيم
                                </th>
                                <th>
                                    رقم الشركة
                                </th>
                                <th>
                                    وقت الموعد
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
                <div
                    class="card-body  border-top d-none"
                    id="dateTimeView"
                >
                    {{--            <div class="col-lg-8 fv-row">--}}
                    {{--                <div class="border rounded mt-5">--}}
                    {{--                    <ul class="list-unstyled row m-0 session_list">--}}

                    {{--                    </ul>--}}
                    {{--                </div>--}}
                    {{--                <div id="dateTimeHiddenInput">--}}

                    {{--                </div>--}}

                    {{--            </div>--}}

                    <div class="row">

                    </div>
                </div>
                <div class="text-center my-5">
                    <button
                        type="button"
                        class="btn btn-lg btn-primary  px-4 publish_btn"
                    >ارسال المواعيد
                    </button>
                </div>

            </div>

            <div
                class="modal  bd-example-modal-lg"
                id="page_modal"
                data-backdrop="static"
                data-keyboard="false"
                role="dialog"
                aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true"
            ></div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{url('/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
    <script>
        $.fn.dataTable.ext.errMode = 'none'
        $(function () {
            $('#service_provider_id').change(function (e){
                const self = $(this)
                const div = $('.service-provider')
                const c = 'd-none'
                self.val() && div.addClass(c) || div.removeClass(c)
            })
            $('#items_table').DataTable({
                'dom': 'tp',
                'searching': false,
                'ordering': false,
                'bPaginate': false,
                'processing': false,
                'stateSave': true,
                'serverSide': true,
                ajax: {
                    url: '{{route('taslem_maintenance.Appointment.notPublished')}}',
                    type: 'GET',
                    'data': function (d) {
                        d.camp_number = $('#camp_number').val()
                        d.box_number = $('#box_number').val()
                    }
                },
                language: {
                    'url': "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {
                        className: 'text-center',
                        data: 'name',
                        name: 'name',
                        sortable:!1,
                        searchable:!1,
                        orderable: !1
                    },
                    {
                        className: 'text-center',
                        data: 'raft_company_location.name',
                        name: 'raft_company_location'
                    },
                    {
                        className: 'text-center',
                        data: 'raft_company_box.box',
                        name: 'box_number'
                    },
                    {
                        className: 'text-center',
                        data: 'raft_company_box.camp',
                        name: 'camp_number'
                    },
                    {
                        className: 'text-center',
                        data: 'raft_company_location.user.phone',
                        name: 'raft_company_location.user.phone',
                    },

                    { className: 'text-center', data: 'start_at', name: 'start_at' },
                    { className: 'text-left', width: '10%', data: 'actions', name: 'actions' }
                ]

            })

        })
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false)
        })

        $('#add_edit_form').validate({
            rules: {
                'start_at': {
                    required: true
                }, 'user_id': {
                    required: true
                }
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                $(element).addClass('is-invalid')
                error.appendTo('#' + $(element).attr('id') + '_error')
            },
            success: function (label, element) {

                $(element).removeClass('is-invalid')
            }
        })

        $('.submit_btn').click(function (e) {
            e.preventDefault()

            if (!$('#add_edit_form').valid()) {
                showAlertMessage('error', 'الرجاء التأكد من جميع المعلومات المطلوبة')
                return false
            }

            const formData = new FormData()
            formData.append('start_at', $('#start_at').val())
            formData.append('box_number', $('#box_number').val())
            formData.append('camp_number', $('#camp_number').val())
            formData.append('service_provider_id', $('#service_provider_id').val())
            formData.append('_token', '{{ csrf_token() }}')

            postData(formData, '{{route('taslem_maintenance.Appointment.store')}}')
        })

        $('.publish_btn').click(function (e) {
            e.preventDefault()

            if (!$('#items_table').DataTable().data().count()) {
                showAlertMessage('error', 'الرجاء اضافة مواعيد اولاً في قائمة المواعيد ليتم ارسالها')
                return false
            }
            const formData = new FormData()
            formData.append('_token', '{{ csrf_token() }}')
            postData(formData, '{{route('taslem_maintenance.Appointment.publish')}}')
        })

        $('#box_number').on('change', function (e) {
            // $('#service_provider_id').val(null).change();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            var url = '{{route('raft_company.get_camp_by_box',':box')}}'

            url = url.replace(':box', $('#box_number').val())

            $.ajax({
                url: url,
                data: {},
                type: 'GET',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        $('#camp_number').find('option').remove()
                        $('#camp_number').html(data.page)
                        $('#camp_number').removeAttr('disabled')
                    }
                },
                error: function (data) {
                    console.log(data)
                    KTApp.unblock('#page_modal')
                    KTApp.unblockPage()
                }
            })
        })

        function delete_row (id) {
            $.ajax({
                url: '{{route('taslem_maintenance.Appointment.delete')}}',
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    id
                },
                beforeSend () {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'الرجاء الانتظار'
                    })
                },
                success: function (data) {

                    if (data.success) {
                        $('#items_table').DataTable().ajax.reload(null, false)
                        showAlertMessage('success', data.message)
                    } else {
                        showAlertMessage('error', 'هناك خطأ ما')
                    }
                    KTApp.unblockPage()

                },
                error: function (data) {
                    console.log(data)
                }
            })
        }

        flatpickr('.datepicker', {
            enableTime: true, dateFormat: 'Y-M-d H:i', minDate: '{{now('Asia/Riyadh')}}'
        })
        var e = document.querySelectorAll('[data-trigger]')
        for (i = 0; i < e.length; ++i) {
            var a = e[i]
            new Choices(a, {
                placeholderValue: 'This is a placeholder set in the config', searchPlaceholderValue:
                    'بحث'
            })
        }
    </script>

@stop
