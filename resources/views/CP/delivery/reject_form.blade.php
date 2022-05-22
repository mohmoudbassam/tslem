<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">رفض الطلب</h5>

        </div>
        <form action="'{{route('delivery.reject')}}'" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="note">سبب الرفض</label>
                            <div class="col-12">
                                <textarea class="form-control" name="note" id="note" rows="10">@foreach($order_starer_last_notes as $notes){{optional($notes->lastnote)->note}}&#13;&#10;&#13;&#10;@endforeach</textarea>


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
        $('#add_edit_form').submit()

    });
</script>
