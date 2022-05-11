@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">إضافة التصاميم</a></li>
                        <li class="breadcrumb-item"><a href="{{route('services_providers')}}">الطلبات</a></li>
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
                        إضافة التصاميم
                    </h4>
                </div>


            </div>
        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="{{route('design_office.save_file')}}"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <div class="mb-3">
                                <label for="title" class="form-label">الرجاء إضافة الملفات هنا </label>
                                <input class="form-control" name="files[]" multiple type="file" placeholder="العنوان"
                                       id="files">
                                <div class="col-12 text-danger" id="files_error"></div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{$order->id}}">


                </div>

            </form>
            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn">تجهيز الطلب</button>
            </div>
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        file_input('#files');

        $('#add_edit_form').validate({
            rules: {
                "files": {
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


            postData(new FormData($('#add_edit_form').get(0)), '{{route('design_office.save_file')}}');
        });
    </script>

@endsection
