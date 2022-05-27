<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">@if($news) إضافة خبر جديد  @else تعديل الخبر  @endif</h5>

        </div>
        <form action="'{{route('news.add_edit')}}'" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="news">الخبر</label>
                               <textarea rows="5" id="news" name="news" class="form-control">@if($news){{$news->news}}@endif</textarea>
                            <div class="col-12 text-danger" id="news_error"></div>
                        </div>
                    </div>


                </div>
            </div>
            @if($news)
            <input type="hidden" name="id" value="{{$news->id}}">
            @endif
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-primary submit_btn">إضافة</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#add_edit_form').validate({
        rules: {

            "news": {
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


        postData(new FormData($('#add_edit_form').get(0)), '{{route('news.add_edit')}}');

    });
</script>
