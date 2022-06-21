<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="view-designer-types-modal-title">مقاولي المخلفات</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="row mt-4 d-flex ">
                    <div class="col-lg-8">

                        <form class="row">
                            <div class="col-lg-8">
                                <label class="col-form-label" for="name">البحث</label>
                                <input type="text" class="form-control" id="name" placeholder="البحث">
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label style="opacity: 0;" class="col-form-label d-block">بحث</label>
                                    <button type="button"  id="search_btn" class="btn btn-primary btn-block">بحث</button>
                                </div>
                            </div>
                        </form>

                    </div>




                </div>
            </div>
            <div class="row">
                <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                       id="items_table_tt" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
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
<script>
    "use strict";
    $('#close-modal').on('click', function () {
        $('#page_model').modal("hide")
    })

    $(function () {
        $('#items_table_tt').DataTable({
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
                }
            },
            language: {
                "url": "{{url('/')}}/assets/datatables/Arabic.json"
            },
            columns: [
                {className: 'text-center', data: 'name', name: 'name'},


            ],


        });

    });

    $('#search_btn').on('click', function(){
        $('#items_table_tt').DataTable().ajax.reload(null, true)
    })

</script>
