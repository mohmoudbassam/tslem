@extends('CP.master')
@section('title')
    انشاء تخصص
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء تخصص</a></li>
                        <li class="breadcrumb-item"><a href="{{route('specialties.index')}}">التخصصات</a></li>
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
                        إنشاء تخصص جديدة
                    </h4>
                </div>

            </div>
        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="{{route('specialties.store')}}">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">الإسم</label>
                            <input type="text" class="form-control" name="name_ar" value="{{old('name_ar')}}" id="name_ar"
                                   placeholder="الإسم">
                            <div class="col-12 text-danger" id="name_ar_error"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">الإسم بالإنجليزية</label>
                            <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" id="name_en"
                                   placeholder="الإسم بالانجليزية">
                            <div class="col-12 text-danger" id="name_en_error"></div>
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

        $('#add_edit_form').validate({
            rules: {
                "name_ar": {
                    required: true,
                }, "name_en": {
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
            // console.log($('#file_ids').val());
            // console.log($('#add_edit_form'));
            // return ;
            if (!$("#add_edit_form").valid())
                return false;

            // $('#add_edit_form').submit()
            const formData = new FormData($('#add_edit_form').get(0));
            postData(formData, '{{route('specialties.store')}}');

        });


    </script>

@endsection
