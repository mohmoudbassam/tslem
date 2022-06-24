<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">
                @lang('models/final_report.' . (($note_exist??$model->final_report()->value('contractor_final_report_note')) ? 'reattach_final_report' : 'attach_final_report'))
            </h5>

        </div>
        <form action="'{{route('licenses.final_report', ['order'=>$model->id])}}'" method="post" id="form_modal" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    @foreach(\App\Models\License::getFinalReportRules($model) as $input => $rules)
                        @include('CP.helpers.form_input', [
                            'col' => ends_with($input, '_path') ? 12 : 6,
                            'id' => $input,
                            'name' => $input,
                            'label' => \App\Models\License::trans($input),
                            'required' => in_array('required', $rules) ?? false,
                            'type' => ends_with($input, '_id') ? 'select' : (
                                ends_with($input, '_path') ? 'file' :
                                    (in_array('numeric', $rules) ? 'number' : 'text')
                                ),
                            'options' => ends_with($input, '_id') ? \App\Models\License::optionsFor($input) : [],
                            'value' => $license->$input,
                            'selected' => $license->$input,
                            'model' => $license,
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

<script src="{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css')}}"/>
<script src="{{url('/assets/libs/flatpickr/l10n/ar.js')}}"></script>
<script>
    file_input('#final_report_path');
    $('#form_modal').validate({
        rules: @json(\App\Models\License::getFinalReportRules($model)),
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

        postData(new FormData($('#form_modal').get(0)), '{{route('licenses.final_report', ['order'=>$model->id])}}', (data) => {
            if (data.success) {
                $('#final-report-modal').modal('hide');
                showAlertMessage('success', data.message);
            } else {
                if (data.message) {
                    showAlertMessage('error', data.message);
                } else {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                }
            }
            KTApp.unblock('#final-report-modal');
            setTimeout(() => location.reload(), 800)
        });
    });

    $(() => {
        @foreach(\App\Models\License::getFinalReportRules() as $column => $rules)
        @if ( isDateAttribute(\App\Models\License::class, $column) )
        flatpickr(".{{$column}}_input", {
            "locale": "{{currentLocale()}}",
            typeCalendar: "Umm al-Qura"
        });
        @endif
        @endforeach
    })
</script>
