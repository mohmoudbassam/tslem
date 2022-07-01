<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            @isset($title)
                <div class="h3">{!! $title !!}</h4></div>
            @endisset
            @if($order->userCanAddReport())
            <div>
                <a class="btn btn-primary btn-sm" href="{!! route('consulting_office.report_add_form',$order->id) !!}">
                    <i class="fa fa-plus"></i>
                    @lang('attributes.add')
                </a>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                       id="consulting-office-reports" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                       role="grid"
                       aria-describedby="DataTables_Table_0_info">
                    <thead>
                    <tr>
                        <th>
                            عنوان التقرير
                        </th>
                        <th>
                            وصف التقرير
                        </th>
                        <th>
                            تاريخ الإنشاء
                        </th>
                        @if($order->userCanAddReport())
                        <th>
                            الخيارات
                        </th>
                        @endif
                    </tr>
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

@section('scripts')
<script>
    $.fn.dataTable.ext.errMode = 'none';
    $(function () {
        $('#consulting-office-reports').DataTable({
            "dom": 'tpi',
            "searching": false,
            "processing": true,
            'stateSave': true,
            "serverSide": true,
            ajax: {
                url: '{{route('consulting_office.reports_list', $order->id)}}',
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
                {className: 'text-center', data: 'created_at', name: 'created_at'},
                @if($order->userCanAddReport())
                {className: 'text-center', data: 'actions', name: 'actions'},
                @endif
            ],
        });
    });
    $('.search_btn').click(function (ev) {
        $('#consulting-office-reports').DataTable().ajax.reload(null, false);
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

                $('#consulting-office-reports').DataTable().ajax.reload(null, false);

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
