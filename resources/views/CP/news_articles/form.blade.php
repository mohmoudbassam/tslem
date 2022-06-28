@extends('CP.master')
@php
    $mode ??= 'create';
    $mode_form ??= ($mode === 'create' ? 'store' : 'update');
    $model = optional($model ?? null);
@endphp
@section('title')
    {{\App\Models\NewsArticle::crudTrans($mode)}}
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{\App\Models\NewsArticle::crudTrans($mode)}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('news_articles')}}">{{\App\Models\NewsArticle::crudTrans('index')}}</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12"><h4>{{\App\Models\NewsArticle::crudTrans($mode)}}</h4></div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form" method="post" action="{{route("news_articles.{$mode_form}", ['news_article'=>$model->id])}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach(\App\Models\NewsArticle::$RULES as $input => $rules)
                                @if($input!=='user_id' && $input!=='image')
                                @include('CP.helpers.form_input', [
                                    'col' => 12,
                                    'id' => $input,
                                    'name' => $input,
                                    'label' => \App\Models\NewsArticle::trans($input),
                                    'required' => in_array('required', $rules) ?? false,
                                    'type' => ends_with($input, '_at') ? 'date' : (ends_with($input, '_id') ? 'select' : (
                                        ends_with($input, '_path') ? 'file' :
                                            (in_array('numeric', $rules) ? 'number' : ($input=='body'?'textarea':($input=='is_published'?'select':'text')))
                                        )),
                                    'options' => ends_with($input, '_id') ? \App\Models\NewsArticle::optionsFor($input) : ($input=='is_published' ? \App\Models\NewsArticle::optionsFor($input) :[]),
                                    'value' => $model->$input,
                                    'selected' => $model->$input,
                                    'model' => $model,
                                ])
                                @endif

                                @if($input == 'image')
                                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                                <label class="col-12" for="media">الصوره</label>
                                <input type="file" name="image[]" multiple class="form-control">
                        </div>
                    </div>
                                </div>
                                @endif

                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="button" class="btn btn-lg btn-primary submit_btn" form="form">
                            {{\App\Models\NewsArticle::crudTrans($mode)}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>
@endsection


@push('js')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js?v=1')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css?v=1')}}"/>
    <script src="{{url('/assets/libs/flatpickr/l10n/ar.js')}}"></script>

    <script>
        $('#form').validate({
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
            if (!$("#form").valid()) return false;

            $('#form').submit()
        });
        CKEDITOR.replace('body', {
            filebrowserUploadUrl: "{{route('news_articles.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
