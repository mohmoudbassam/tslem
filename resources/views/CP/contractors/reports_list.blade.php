<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            @isset($title)
                <div class="h3">{!! $title !!}</h4></div>
            @endisset
            <div>
                <a class="btn btn-primary btn-sm" href="{!! route('contractor.add_report_form', ['order' => $order->id]) !!}">
                    <i class="fa fa-plus"></i>
                    @lang('attributes.add')
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
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
                            عنوان التقرير
                        </th>
                        <th>
                            الوصف
                        </th>

                        <th>
                            تاريخ الإنشاء
                        </th>
                        <th>
                            الخيارات
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
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

@section('scripts')
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
                    url: '{{route('contractor.report_list',['order'=>$order->id])}}',
                    type: 'GET',
                    'data': function (d) {
                        d.name = $('#name').val()
                        d.type = $('#type').val()

                    }
                },
                language: {
                    'url': "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    { className: 'text-center', data: 'title', name: 'title' },

                    { className: 'text-center', data: 'description', name: 'description' },
                    { className: 'text-center space-nowrap', data: 'created_at', name: 'created_at' },
                    { className: 'text-center', data: 'actions', name: 'actions' }
                ]

            })

        })
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false)
        })

        function accept (id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: '',
                data: {
                    id: id
                },
                type: 'POST',

                beforeSend () {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'الرجاء الإنتظار....'
                    })
                },
                success: function (data) {
                    if (data.success) {
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

        function delete_report (id) {
            Swal.fire({
                title: 'هل انت متاكد من حذف التقرير ؟',
                text: '',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#84dc61',
                cancelButtonColor: '#d33',
                confirmButtonText: 'تأكيد',
                cancelButtonText: 'لا'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{route('contractor.delete_report')}}',
                        type: 'POST',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id
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
            })
        }

    </script>
@endsection
