@extends('CP.master')@section('title', __("attributes.add_reports"))
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">الرئيسية</li>
                        <li class="breadcrumb-item">
                            <a href="{{route('design_office.consulting.orders')}}">الطلبات</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{!! route('consulting_office.reports_view_details',$order) !!}">@lang('attributes.view_order')</a>
                        </li>
                        <li class="breadcrumb-item">@lang("attributes.add_reports")</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>@lang('attributes.add_reports')</h4>
        </div>
        <div class="card-body">
            <form
                id="add_edit_form"
                method="post"
                action="{{route('consulting_office.add_report',$order)}}"
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
                                >العنوان
                                </label>
                                <input
                                    class="form-control"
                                    name="title"
                                    type="text"
                                    placeholder="العنوان"
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
                            >الوصف
                            </label>
                            <textarea
                                class="form-control"
                                rows="5"
                                name="description"
                                placeholder="الوصف"
                                id="description"
                            ></textarea>
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
                        name="order_id"
                        value="{{$order->id}}"
                    >
                </div>
            </form>
            <div class="d-flex flex-wrap gap-3">
                <button
                    type="button"
                    class="btn btn-primary submit_btn"
                >@lang("attributes.add")</button>
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
        file_input('#files')
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
                return
            $('#add_edit_form').submit()
        })
    </script>
@endsection
