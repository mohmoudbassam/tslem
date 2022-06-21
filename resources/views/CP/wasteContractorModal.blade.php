<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="view-designer-types-modal-title">مقاولي المخلفات</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead>

                        <tr>
                            <th>الإسم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $_data)
                            <tr>

                                <td>{{$_data['name']}}</td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button type="button" id="close-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
        </div>
    </div>
</div>
<script>
    $('#close-modal').on('click', function () {
        $('#page_model').modal("hide")
    })
</script>
