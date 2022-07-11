@extends('CP.master')

@section('title', "عرض التفاصيل" )

@section('style')
    <link
        href="{{url('/')}}/assets/dropzone.min.css"
        id="bootstrap-style"
        rel="stylesheet"
        type="text/css"
    />
    <style>
        .details_p {
            font-size: 20px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">
                        الرئيسية
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('taslem_maintenance.Appointment.index')}}">
                            {{ trans_choice('choice.Appointments', 2) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        عرض تفاصيل الموعد
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-sm-0 font-size-18 text-center">عرض تفاصيل الموعد</h4>
        </div>
        <div class="card-body">
            <div class="border p-5 py-4 pb-3 mb-3">
                <div class="row">
                    <div class="col-md-6 my-1">
                        <p>
                            <span class="bold">مركز الخدمة :</span> {{ $model->service_provider_name }}</p>
                    </div>
                    <div class="col-md-6 my-1">
                        <p>
                            <span class="bold">المربع :</span> {{ $model->raftCompanyBox->box }}</p>
                    </div>
                    <div class="col-md-6 my-1">
                        <p>
                            <span class="bold">المخيم :</span> {{ $model->raftCompanyBox->camp }}</p>
                    </div>
                    <div class="col-md-6 my-1">
                        <p>
                            <span class="bold">شركة الطوافة :</span> {{ $model->raftCompanyLocation->name }}</p>
                    </div>
                    <div class="col-md-6 my-1">
                        <p>
                            <span class="bold">الموعد :</span> {{$model->start_at_to_string}} </p>
                    </div>
                </div>
            </div>
            <form
                action="{{route('taslem_maintenance.Appointment.update', $model->id)}}"
                id="add_edit_form"
                method="post"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="row">
                    <div class="col-lg-4 ">
                        @if($model->getFirstFileUrl())
                            <div class="text-center mb-3">
                                <a
                                    class="btn btn-primary"
                                    href="{{ $model->getFirstFileUrl() }}"
                                    target="_blank"
                                >استعرض الملف
                                </a>
                            </div>
                        @endif
                        <div class="dropzone">
                            <div id="dropzone_file">
                                <div class="fallback">
                                    <input
                                        name="dropzone_file"
                                        type="file"
                                        id="dropzone_file"
                                        accept="application/pdf"
                                    >
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-5 text-muted bx bx-cloud-upload"></i>
                                    </div>
                                    <h5>محضر اعادة تسليم المخيم</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <label
                        for="note"
                        class="mb-2 h5"
                    >
                        الملاحظات
                    </label>
                    <textarea
                        class="form-control"
                        name="note"
                        id="note"
                        rows="10"
                    >{!! nl2br($model->notes) !!}</textarea>
                    <div
                        class="text-danger"
                        id="note_error"
                    ></div>
                </div>
                <input
                    type="hidden"
                    id="id"
                    name="id"
                    value="{{$model->id}}"
                >
                <div class=" text-center mt-5 mb-4">
                    <div>
                        <button
                            type="submit"
                            class="btn btn-lg btn-primary submit_btn px-4"
                        >إرسال
                        </button>
                    </div>
                </div>
            </form>
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

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false
        $(document).ready(function () {
                $('#dropzone_file').dropzone({
                    url: "{{route('taslem_maintenance.Appointment.upload', $model)}}",
                    paramName: 'file', // The name that will be used to transfer the file
                    maxFiles: 1,
                    maxFilesize: 10, // MB
                    addRemoveLinks: !1,
                    accept: function (file, done) {
                        if (file.type !== 'application/pdf') {
                            showAlertMessage('error', 'الرجاء ارفاق ملف pdf')
                            done('الرجاء ارفاق ملف pdf')
                        } else { done() }
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (file, r) {
                        if(r?.success === !0){
                            window.location.reload()
                        }
                    }
                })
            }
        )

        $('#add_edit_form').validate({
            rules: {
                'note': {
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

            postData(new FormData($('#add_edit_form')[0]), '{{route('taslem_maintenance.Appointment.update',$model)}}')
        })

    </script>

@endsection
