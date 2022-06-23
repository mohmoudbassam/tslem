<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">سبب الرفض المستخدم : {{$user->name}}</h5>

        </div>
        <form action="'{{route('users.request.reject')}}'" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="reject_reason">الرجاء ادخال سبب الرفض</label>
                            <div class="col-12">
                                <textarea class="form-control" name="reject_reason" id="reject_reason" rows="3"></textarea>
                            </div>
                            <div class="col-12 text-danger" id="reject_reason_error"></div>
                        </div>
                    </div>

                </div>
            </div>
            <input type="hidden" name="id" value="{{$user->id}}">
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-primary submit_btn">ارسال</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#add_edit_form').validate({
        rules: {
            "reject_reason": {
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


        postData(new FormData($('#add_edit_form').get(0)), '{{route('users.request.reject')}}');

    });
</script>
