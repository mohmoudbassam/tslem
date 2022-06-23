<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">معلومات الرخصة</h5>

        </div>
        <form action="'{{route('news_articles.order_news_article_create', ['order'=>$model->id])}}'" method="post" id="form_modal" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    @foreach(\App\Models\NewsArticle::$ORDER_APPROVED_RULES as $input => $rules)
                        @include('CP.helpers.form_input', [
                            'col' => $input === 'map_path' ? 12 : 6,
                            'id' => $input,
                            'name' => $input,
                            'label' => \App\Models\NewsArticle::trans($input),
                            'required' => in_array('required', $rules) ?? false,
                            'type' => ends_with($input, '_id') ? 'select' : (
                                ends_with($input, '_path') ? 'file' :
                                    (in_array('numeric', $rules) ? 'number' : 'text')
                                ),
                            'options' => ends_with($input, '_id') ? \App\Models\NewsArticle::optionsFor($input) : [],
                            'value' => $news_article->$input,
                            'selected' => $news_article->$input,
                            'model' => $news_article,
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
    file_input('#map_path');
    $('#form_modal').validate({
        rules: @json(\App\Models\NewsArticle::getRules()),
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

        postData(new FormData($('#form_modal').get(0)), '{{route('news_articles.order_news_article_create', ['order'=>$model->id])}}', (data) => {
            if (data.success) {
                $('#view-user-files-modal').modal('hide');
                showAlertMessage('success', data.message);
            } else {
                if (data.message) {
                    showAlertMessage('error', data.message);
                } else {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                }
            }
            KTApp.unblock('#view-user-files-modal');
        });
    });
</script>
