<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">رفض الطلب</h5>

        </div>
        <form action="'{{route('Sharer.reject')}}'" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="note">سبب الرفض</label>
                            <div class="col-12">
                                <textarea class="form-control" name="note" id="note" rows="10"></textarea>
                            </div>
                            <div class="col-12 text-danger" id="note_error"></div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="{{$order->id}}">
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-danger submit_btn">رفض</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#add_edit_form').validate({
        rules: {
            "note": {
                required: true,
            },
        },
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: true,
        errorPlacement: function (error, element) {
            $(element).addClass("is-invalid");
            error.appendTo('#' + $(element).attr('id') + '_error');
        },
        success: function (label, element) {

            $(element).removeClass("is-invalid");
        }
    });

    $('.submit_btn').click(function (e) {
        e.preventDefault();

        if (!$("#add_edit_form").valid())
            return false;



        $.ajax({
            url: '{{route('Sharer.reject')}}',
            data: new FormData($('#add_edit_form').get(0)),
            type: "POST",
            processData: false,
            contentType: false,
            beforeSend() {
                KTApp.block('#page_modal', {
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'الرجاء الإنتظار'
                });
            },
            success: function (data) {
                if (data.success) {
                    $('#page_modal').modal('hide');

                    showAlertMessage('success', data.message);

                    setTimeout(function(){
                        window.location.reload()
                    },500);
                } else {
                    if (data.message) {

                    } else {
                        showAlertMessage('error', 'حدث خطأ في النظام');
                    }
                }
                KTApp.unblockPage();
            },
            error: function (data) {
                console.log(data);
                KTApp.unblock('#page_modal');
                KTApp.unblockPage();
            },
        });
    });
</script>
