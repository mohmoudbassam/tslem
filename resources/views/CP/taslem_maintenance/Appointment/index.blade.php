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
    <div class="row align-items-center">
        <div class="col-lg">
            @if($isToday)
                <h2>مواعيد اليوم</h2>
            @else
                <h2>جميع المواعيد</h2>
            @endif
        </div>
        <div class="col-lg-auto mt-3 mt-lg-0">
            <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                <h4 class="mb-sm-0 font-size-18 me-2">
                    <a
                        class="btn btn-primary"
                        href="{{route('taslem_maintenance.Appointment.create')}}"
                    >
                        <i
                            class="fa fa-plus pe-2"
                        ></i>
                        إضافة موعد
                    </a>
                </h4>

                @if(!$isToday)
                    <h4 class="mb-sm-0 font-size-18">
                        <a
                            class="btn btn-primary"
                            href="{{route('taslem_maintenance.Appointment.index',['today' => !0])}}"
                        >
                            <i class="fa fa-clock pe-2"></i>
                            مواعيد اليوم
                        </a>
                    </h4>
                @else
                    <h4 class="mb-sm-0 font-size-18">
                        <a
                            class="btn btn-primary"
                            href="{{route('taslem_maintenance.Appointment.index')}}"
                        >
                            <i class="fa fa-clock pe-2"></i>
                            جميع المواعيد
                        </a>
                    </h4>

                    <h4 class="mb-sm-0 font-size-18 m-lg-2">
                        <a
                            class="btn btn-primary"
                            href="{{ route('taslem_maintenance.Appointment.export') }}"
                        >
                            <i class="fa fa-file-pdf pe-2"></i>
                            تصدير
                        </a>
                    </h4>
                @endif
                <div class="page-title-box d-sm-flex align-items-center justify-content-end"></div>
            </div>
        </div>
        <div class="card">
            @if(!$isToday)
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <form
                                class="row gx-3 gy-2 mb-4 mb-lg-0 "
                                id="form_data"
                            >
                                <div class="col-lg-3 col-xxl-2">
                                    <label for="">من</label>
                                    <input
                                        type="text"
                                        class="form-control datepicker"
                                        id="from_date"
                                        placeholder=""
                                    >
                                </div>
                                <div class="col-lg-3 col-xxl-2">
                                    <label for="">الى</label>
                                    <input
                                        type="text"
                                        class="form-control datepicker"
                                        id="to_date"
                                        placeholder=""
                                    >
                                </div>
                                <div class="col-lg-3 col-xxl-2 service-provider">
                                    <label
                                        class="form-label"
                                        for="box_number"
                                    >رقم المربع
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
                                <div class="col-lg-3 col-xxl-2 service-provider">
                                    <label
                                        class="form-label"
                                        for="camp_number"
                                    >رقم المخيم
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
                                <div
                                    class="col-sm-auto ms-auto"
                                    style="margin-top:1.9rem;"
                                >
                                    <button
                                        type="button"
                                        class="btn btn-primary search_btn px-4 me-2"
                                    >
                                        <i
                                            class="fa fa-search me-1"
                                        ></i>
                                        بحث
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-secondary reset_btn px-4"
                                    >
                                        <i
                                            class="far fa-times me-1"
                                        ></i>
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table
                            class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                            id="items_table"
                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;"
                            role="grid"
                            aria-describedby="DataTables_Table_0_info"
                        >
                            <thead>
                            <tr>
                                <th>
                                    مركز الخدمة
                                </th>
                                <th>
                                    اسم شركة الطوافة
                                </th>
                                <th>
                                    رقم المربع
                                </th>
                                <th>
                                    رقم المخيم
                                </th>
                                <th>
                                    رقم الجوال
                                </th>
                                <th>
                                    وقت الموعد
                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
        <div
            class="modal fade"
            id="page_modal"
            tabindex="-1"
            role="dialog"
            data-toggle="modal"
            data-backdrop="static"
            data-keyboard="false"
            aria-labelledby="view-user-files-modal-title"
            aria-hidden="true"
        >

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>

    <script>
        $.fn.dataTable.ext.errMode = 'none'
        $(function () {
            $('#items_table').DataTable({
                'dom': 'tpi',
                'searching': false,
                'processing': true,
                'stateSave': true,
                'serverSide': true,
                ajax: {
                    url: '{{route('taslem_maintenance.Appointment.list',["today" => ($isToday ?? !1 )])}}',
                    type: 'GET',
                    data: function (d) {
                        d.from_date = $('#from_date').val()
                        d.to_date = $('#to_date').val()
                        d.camp_number = $('#camp_number').val()
                        d.box_number = $('#box_number').val()
                    }
                },
                language: {
                    'url': "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {
                        className: 'text-right',
                        data: 'name',
                        name: 'name',
                        sortable: !1,
                        searchable: !1,
                        orderable: !1
                    },
                    {
                        className: 'text-right',
                        data: 'raft_company_location.name',
                        name: 'raft_company_location.name',
                        orderable: false
                    },
                    {
                        className: 'text-center',
                        data: 'raft_company_box.box',
                        name: 'raft_company_box.box',
                        orderable: false
                    },
                    {
                        className: 'text-center',
                        data: 'raft_company_box.camp',
                        name: 'raft_company_box.camp',
                        orderable: false
                    },
                    {
                        className: 'text-center',
                        data: 'raft_company_location.user.phone',
                        name: 'raft_company_location.user.phone',
                        orderable: false
                    },
                    { className: 'text-center', data: 'start_at', name: 'start_at' },
                    { className: 'text-left', data: 'actions', name: 'actions' }

                ]

            })
        })
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false)
        })

        $('#box_number').on('change', function (e) {
            $('#camp_number').find('option').remove()
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

        $('.reset_btn').click(function (ev) {
            $('#camp_number').find('option').remove()
            $('#form_data').trigger('reset')
            $('#items_table').DataTable().ajax.reload(null, false)
        })
        flatpickr('.datepicker')
        function send_sms (id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: '{{route('taslem_maintenance.Appointment.send_sms')}}',
                data: {
                    id: id
                },
                type: 'POST',

                beforeSend () {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'جاري الانتظار'
                    })
                },
                success: function (data) {
                    if (data.success) {
                        $('#items_table').DataTable().ajax.reload(null, false)
                        showAlertMessage('success', data.message)
                    } else {
                        showAlertMessage('error', 'حدث خطأ في النظام')
                    }

                    KTApp.unblockPage()
                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في النظام')
                    KTApp.unblockPage()
                }
            })
        }
        var e = document.querySelectorAll('[data-trigger]')
        for (i = 0; i < e.length; ++i) {
            var a = e[i]
            new Choices(a, {
                placeholderValue: 'This is a placeholder set in the config', searchPlaceholderValue:
                    'بحث'
            })
        }
    </script>
@endsection
