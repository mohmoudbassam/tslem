<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{$title ?? 'رفض الطلب'}}</h5>
        </div>
        <form action="" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="note">{{$label ?? 'سبب الرفض'}}</label>
                            <div class="col-12">
                                <textarea class="form-control" name="note" id="note"
                                          rows="10">{{$note ?? ''}}</textarea>


                            </div>
                            <div class="col-12 text-danger" id="note_error"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-danger submit_btn">ارسال</button>
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


        let url = "{{ $url ?? route('delivery.copy_note') }}";
        let data = {
            "_token": "{{ csrf_token() }}",
            "id": "{{$id ?? optional($order)->id}}",
            "type": "{{$type ?? ''}}",
            "note": $('#note').val()
        };

        $.ajax({
            url: url,
            data: data,
            type: "POST",
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    showAlertMessage('success', data.message);
                    setTimeout(function () {
                        window.location.reload()
                    }, 500);
                } else {
                    showAlertMessage('error', data.message);
                }

            },
            error: function (data) {
                showAlertMessage('error', 'حدث خطأ');
            },
        });
    });
</script>
