@extends('CP.master')
@section('title')
    تعديل التقرير
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">الرئيسية</li>
                        <li class="breadcrumb-item">
                            <a href="{{route('contractor.orders')}}">الطلبات</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{!! route('contractor.order_details', ['order' => $order->id]) !!}#reports">@lang('attributes.view_order')</a>
                        </li>
                        <li class="breadcrumb-item">@lang("attributes.update_report")</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>@lang("attributes.update_report")</h3>
        </div>
        <div class="card-body">
            <form
                id="add_edit_form"
                method="post"
                action="{{route('contractor.update_report')}}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <div class="mb-3">
                                <label
                                    for="title"
                                    class="form-label"
                                >عنوان التقرير
                                </label>
                                <input
                                    class="form-control"
                                    name="title"
                                    type="text"
                                    placeholder="العنوان"
                                    value="{{$report->title}}"
                                    id="title"
                                >
                                <div
                                    class="col-12 text-danger"
                                    id="title_error"
                                ></div>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label
                                for="description"
                                class="form-label"
                            >وصف التقرير
                            </label>
                            <textarea
                                class="form-control"
                                rows="5"
                                name="description"
                                placeholder="الوصف"
                                id="description"
                            >{{$report->description}}</textarea>
                            <div
                                class="col-12 text-danger"
                                id="description_error"
                            ></div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label
                                for="files"
                                class="form-label"
                            >مرفقات التقرير
                            </label>
                            <input
                                class="form-control"
                                type="file"
                                name="files[]"
                                id="files"
                                multiple
                            >
                            <div
                                class="col-12 text-danger"
                                id="files_error"
                            ></div>
                        </div>
                    </div>
                    <input
                        type="hidden"
                        name="report_id"
                        value="{{$report->id}}"
                    >
                </div>
            </form>
            <div class="d-flex flex-wrap gap-3">
                <button
                    type="button"
                    class="btn btn-lg btn-primary submit_btn"
                >
                    @lang("attributes.update_report")
                </button>
            </div>
        </div>
    </div>

    <div
        class="modal  bd-example-modal-lg"
        id="page_modal"
        data-backdrop="static"
        data-keyboard="false"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    ></div>

@endsection

@section('scripts')
    <script>

        @if($report->files->isNotEmpty())
        file_input('#files', {
            initialPreview: @json($report->files->pluck('path')->toArray()),
            initialPreviewConfig: [
                    @foreach($report->files as $file){
                    caption: '',
                    width: '120px',
                    url: '{{route('contractor.delete_file',['file'=>$file->id])}}',
                    key: '{{$file->id}}'
                },
                @endforeach
            ]
        }, true)
        @else
        file_input('#files')
        @endif
        $('#add_edit_form').validate({
            rules: {
                'title': {
                    required: true
                },
                'description': {
                    required: true
                }

            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                $(element).addClass('is-invalid')
                error.appendTo('#' + $(element).attr('id') + '_error')
            },
            success: function (label, element) {

                $(element).removeClass('is-invalid')
            }
        })

        $('.submit_btn').click(function (e) {
            e.preventDefault()

            if (!$('#add_edit_form').valid())
                return false

            $('#add_edit_form').submit()

        })

    </script>

@endsection
