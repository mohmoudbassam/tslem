<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">
                @lang('models/order.agreement_name')
            </h5>

        </div>
        <form action="'{{route('design_office.order_agreement', ['order'=>$model->id])}}'" method="post" id="form_modal" enctype="multipart/form-data">
            @csrf
            <div class="modal-body px-4">
                <div class="row ">
                    <div class=" mt-2 border border-dark ">
                        <div class="col-12 ms-1 text-lg-start font-size-16 bold">
                            <br />

                            {!! \App\Models\Order::trans("agreement_text") !!}
                            <br />
                            <br />
                            <br />
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-check p-2 ms-3" style="margin-right: 15px;">
                                <input class="form-check-input" type="checkbox" value="1" name="agreed" id="agreed_checkbox">
                                <label class="form-check-label bold font-size-16" for="agreed_checkbox" style="font-weight: bold;">
                                    @lang('models/order.agree')
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>--}}
                <button type="button" class="btn btn-primary submit_btn">إرسال</button>
            </div>
        </form>
    </div>
</div>

<script src="{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css')}}"/>
<script src="{{url('/assets/libs/flatpickr/l10n/ar.js')}}"></script>
<script>
    $('#form_modal').validate({
        rules: @json(\App\Models\Order::getRules()),
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

    $('#agreed_checkbox').change(function (e) {
        e.preventDefault();
        let elm = e.target;
        $('.submit_btn').prop('disabled', !elm.checked);
    })

    $('.submit_btn').click(function (e) {
        e.preventDefault();
        if (!$("#form_modal").valid())
            return false;

        postData(new FormData($('#form_modal').get(0)), '{{route('design_office.order_agreement', ['order'=>$model->id])}}', (data) => {
            if (data.success) {
                showAlertMessage('success', data.message);
            } else {
                if (data.message) {
                    showAlertMessage('error', data.message);
                } else {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                }
            }
            KTApp.unblock('#agreement-modal');
            setTimeout(() => location.reload(), 800)
        });
    });

</script>
