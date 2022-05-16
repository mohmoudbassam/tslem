@extends('CP.master')
@section('title')
    إضافة تقرير
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">أضافة تقرير</a></li>
                        <li class="breadcrumb-item"><a href="{{route('contractor')}}">الطلبات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="{{route('contractor.add_edit_report')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <div class="mb-3">
                                <label for="title" class="form-label">عنوان الطلب</label>
                                <input class="form-control" name="title" type="text" placeholder="العنوان" id="title">
                                <div class="col-12 text-danger" id="title_error"></div>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">وصف الطلب</label>
                            <textarea class="form-control" rows="5" name="description"  placeholder="الوصف" id="description"></textarea>
                            <div class="col-12 text-danger" id="description_error"></div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="files" class="form-label">مرفقات التقرير</label>
                            <input class="form-control" type="file"  name="files[]"   id="files" multiple>
                            <div class="col-12 text-danger" id="files_error"></div>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" value="{{$order->id}}">


                </div>

            </form>
            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء تقرير</button>
            </div>
        </div>
    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>
        file_input('#files');

        $('#add_edit_form').validate({
            rules: {
                "title": {
                    required: true,
                },
                "description": {
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

@endsection