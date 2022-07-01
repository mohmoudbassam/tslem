@extends('CP.master')
@php
    $mode ??= 'create';
    $mode_form ??= ($mode === 'create' ? 'store' : 'update');
    $model = optional($model ?? null);
@endphp
@section('title')
    {{\App\Models\OrderLogs::crudTrans($mode)}}
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{\App\Models\OrderLogs::crudTrans($mode)}}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{route('order_logs')}}">{{\App\Models\OrderLogs::crudTrans('index')}}</a></li>
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
                        <div class="col-lg-12"><h4>{{\App\Models\OrderLogs::crudTrans($mode)}}</h4></div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form" method="post" action="{{route("order_logs.{$mode_form}", ['order_log'=>$model->id])}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach(\App\Models\OrderLogs::$RULES as $input => $rules)
                                @include('CP.helpers.form_input', [
                                    'col' => 6,
                                    'id' => $input,
                                    'name' => $input,
                                    'label' => \App\Models\OrderLogs::trans($input),
                                    'required' => in_array('required', $rules) ?? false,
                                    'type' => ends_with($input, '_id') ? 'select' : (
                                        ends_with($input, '_path') ? 'file' :
                                            (in_array('numeric', $rules) ? 'number' : 'text')
                                        ),
                                    'options' => ends_with($input, '_id') ? \App\Models\OrderLogs::optionsFor($input) : [],
                                    'value' => $model->$input,
                                    'selected' => $model->$input,
                                    'model' => $model,
                                ])
                            @endforeach
                            <div class="form-group col-lg-12 col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="attachment">المرفقات</label>
                                            <input type="file" class="form-control"
                                                   id="attachment"
                                                   name="attachment">
                                            <div class="col-12 text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="button" class="btn btn-lg btn-primary submit_btn" form="form">
                            {{\App\Models\OrderLogs::crudTrans($mode)}}</button>
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
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js?v=1')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{url('/assets/libs/flatpickr/flatpickr.min.css?v=1')}}"/>
    <script src="{{url('/assets/libs/flatpickr/l10n/ar.js')}}"></script>

    <script>

        $('#form').validate({
            rules: @json(\App\Models\OrderLogs::getRules()),
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

        $(() => {
            @foreach(\App\Models\OrderLogs::$RULES as $column => $rules)
            @if(isDateAttribute(\App\Models\OrderLogs::class, $column))

            flatpickr(".{{$column}}_input", {
                locale: "{{currentLocale()}}",
                typeCalendar: "Umm al-Qura"
            });

            @endif
            @endforeach
        })
    </script>
@endpush
