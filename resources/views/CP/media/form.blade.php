<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">@if($media) إضافة ملف جديد @else تعديل الملف @endif</h5>

        </div>
        <form action="'{{route('media.add_edit')}}'" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="media">النوع</label>
                            <select class="form-control" name="type">
                                <option value="image" {{ old('type' , $media ? $media->type : '') == 'image' ? 'selected' : ''}}>صوره</option>
                                <option value="video" {{ old('type' , $media ? $media->type : '') == 'video' ? 'selected' : ''}}>فيديو</option>
                            </select>
                            <div class="col-12 text-danger" id="media_error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="media">العنوان</label>
                            <input type="text" name="title" value="{{old('title' , $media ? $media->title : '')}}" class="form-control">
                            <div class="col-12 text-danger" id="media_error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="media">الملف</label>
                            <input type="file" name="file" class="form-control">
                            <div class="col-12 text-danger" id="media_error"></div>
                        </div>
                    </div>
                </div>
            </div>
            @if($media)
            <input type="hidden" name="id" value="{{$media->id}}">
            @endif
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                @if($media)
                <button type="button" class="btn btn-primary submit_btn">تعديل</button>
                @else
                <button type="button" class="btn btn-primary submit_btn">إضافة</button>
                @endif

            </div>
        </form>
    </div>
</div>

<script>
    $('#add_edit_form').validate({
        rules: {
            "file": {
                required: true,
            },
        },
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: true,
        errorPlacement: function(error, element) {
            $(element).addClass("is-invalid");
            error.appendTo('#' + $(element).attr('id') + '_error');
        },
        success: function(label, element) {

            $(element).removeClass("is-invalid");
        }
    });

    $('.submit_btn').click(function(e) {
        e.preventDefault();

        if (!$("#add_edit_form").valid())
            return false;


        postData(new FormData($('#add_edit_form').get(0)), "{{route('media.add_edit')}}");

    });
</script>