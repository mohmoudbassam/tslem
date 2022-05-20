@extends('CP.master')
@section('title')
    انشاء تقرير
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء تقرير</a></li>
                        <li class="breadcrumb-item"><a href="{{route('delivery')}}">الطلبات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <h4>
                        انشاء تقرير
                    </h4>
                </div>

            </div>
        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="{{route('delivery.add_report')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                   

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="title">عنوان التقرير</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <div class="col-12 text-danger" id="title_error"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description">وصف التقرير</label>
                            <textarea type="text" class="form-control" id="description" name="description">

                            </textarea>
                            <div class="col-12 text-danger" id="description_error"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="files">مرفقات</label>
                            <input type="file" class="form-control" multiple id="files" name="files[]">
                            <div class="col-12 text-danger" id="files_error"></div>
                        </div>
                    </div>
                </div>
               
            </form>

            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء</button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                }, "description": {
                    required: true,
                }, "files": {
                    required: true,
                }
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


            postData(new FormData($('#add_edit_form').get(0)), '{{route('delivery.add_report')}}');
        });



    </script>

@endsection
