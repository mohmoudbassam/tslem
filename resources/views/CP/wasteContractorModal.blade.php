<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="view-designer-types-modal-title">مقاولي المخلفات</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                       id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                       role="grid"
                       aria-describedby="DataTables_Table_0_info">
                    <thead>
                    <th>
                        الاسم
                    </th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>
        <div class="modal-footer">
            <button type="button" id="close-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#close-modal').on('click', function () {
            $('#page_model').modal("hide")
        })
        console.log('sdfsdf')
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route('west_list')}}',
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
                    {className: 'text-center', data: 'enabled', name: 'enabled',searchable:false,orderable:false},
                    {className: 'text-center', data: 'actions', name: 'actions',searchable:false,orderable:false},

                ],


            });

        });
    </script>

@endpush

