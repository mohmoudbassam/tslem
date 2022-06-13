<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">معلومات الرخصة</h5>

        </div>
        <form action="'{{route('licenses.order_license_create', ['order'=>$model->id])}}'" method="post" id="form_modal" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    @foreach(\App\Models\License::$RULES as $input => $rules)
                        @include('CP.helpers.form_input', [
                            'col' => 6,
                            'id' => $input,
                            'name' => $input,
                            'label' => \App\Models\License::trans($input),
                            'required' => in_array('required', $rules) ?? false,
                            'type' => ends_with($input, '_id') ? 'select' : (in_array('numeric', $rules) ? 'number' : 'text'),
                            'options' => ends_with($input, '_id') ? \App\Models\License::optionsFor($input) : [],
                            'value' => $model->$input,
                            'selected' => $model->$input,
                            'model' => $model,
                        ])
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-primary submit_btn">إرسال</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#form_modal').validate({
        rules: @json(\App\Models\License::getRules()),
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
        if (!$("#form_modal").valid())
            return false;

        postData(new FormData($('#form_modal').get(0)), '{{route('licenses.order_license_create', ['order'=>$model->id])}}');
    });
</script>
