@extends('CP.sharer_layout')
@section('title')
    رفع الملفات في المواعيد
@endsection
@section('style')
    <link href="{{url('/')}}/assets/dropzone.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
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

        <div class="card-header">
            <h4 class="mb-sm-0 font-size-18 text-center">إضافة الملفات إلى موعد المربع والمخيم</h4>
        </div>
        <div class="card-body">
            <div class="border p-5 py-4 pb-3 mb-3">
                <div class="row">
                    <div class="col-md-6 my-1">
                        <p ><span class="bold">المربع : </span>{{ $session->RaftCompanyBox->box }}</p>
                    </div>
                    <div class="col-md-6 my-1">
                        <p ><span class="bold">المخيم : </span>{{ $session->RaftCompanyBox->camp }}</p>
                    </div>
                    <div class="col-md-6 my-1">
                        <p ><span class="bold">شركة الطوافة : </span>{{ $session->RaftCompanyLocation->name }}</p>
                    </div>
                    <div class="col-md-6 my-1">
                        <p ><span class="bold">الموعد :</span>{{$session->start_at}} </p>
                    </div>
                </div>
            </div>
            <form action="{{route('taslem_maintenance.save_note')}}" method="post" enctype="multipart/form-">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        @if($session->RaftCompanyBox->file_first)
                        <div class="text-center mb-3">
                            <a class="btn btn-primary" href="{{ $session->RaftCompanyBox->file_first_fullpath }}" target="_blank">استعرض الملف المرفوع</a>
                        </div>
                        @endif
                        <div class="dropzone">
                            <div id="dropzone_file_first">
                                <div class="fallback">
                                    <input name="file_first" type="file" id="file_first">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-5 text-muted bx bx-cloud-upload"></i>
                                    </div>

                                    <h5>محضر قراءة عداد الكهرباء الخاص بالمخيم</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" >
                         @if($session->RaftCompanyBox->file_second)
                        <div class="text-center mb-3">
                            <a class="btn btn-primary" href="{{ $session->RaftCompanyBox->file_second_fullpath }}" target="_blank">استعرض الملف المرفوع</a>
                        </div>
                        @endif
                        <div class="dropzone">
                            <div id="dropzone_file_second">
                                <div class="fallback">
                                    <input name="dropzone_file_second" type="file" id="dropzone_file_second">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-5 text-muted bx bx-cloud-upload"></i>
                                    </div>

                                    <h5>كشف بالملاحظات والتلفيات والمفقودات عند تسليم المخيمات للجهات المستفيدة لموسم حج 1443 هـ</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 " >
                    @if($session->RaftCompanyBox->file_third)
                        <div class="text-center mb-3">
                            <a class="btn btn-primary" href="{{ $session->RaftCompanyBox->file_third_fullpath }}" target="_blank">استعرض الملف المرفوع</a>
                        </div>
                        @endif
                        <div class="dropzone">

                            <div id="dropzone_file_third">
                                <div class="fallback">
                                    <input name="dropzone_file_third" type="file" id="dropzone_file_third">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-5 text-muted bx bx-cloud-upload"></i>
                                    </div>
                                    <h5>محضر تسليم المخيمات</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group mt-4">
                    <label for="note" class="mb-2"><h5>الملاحظات</h5></label>
                        <textarea class="form-control" name="note" id="note"
                        rows="10">{{ $session->RaftCompanyBox->tasleem_notes }}</textarea>
                        <div class="text-danger" id="note_error"></div>
                </div>
                <input type="hidden" id="session_id" name="session_id" value="{{$session->id}}">

                <div class=" text-center mt-5 mb-4">
                    <div>
                        <button type="submit" class="btn btn-lg btn-primary submit_btn px-4">إرسال</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

@endsection

@section('scripts')

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function () {

                $('#dropzone_file_first').dropzone({
                    url: "{{route('taslem_maintenance.upload_file',['type' => 'file_first','session_id'=>$session->id])}}",
                    paramName: "file", // The name that will be used to transfer the file
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (file, response) {


                    },

                });
                $('#dropzone_file_second').dropzone({
                    url: "{{route('taslem_maintenance.upload_file',['type' => 'file_second','session_id'=>$session->id])}}",
                    paramName: "file", // The name that will be used to transfer the file
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (file, response) {

                    },

                });
                $('#dropzone_file_third').dropzone({
                    url: "{{route('taslem_maintenance.upload_file',['type' => 'file_third','session_id'=>$session->id])}}",
                    paramName: "file", // The name that will be used to transfer the file
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (file, response) {

                    },

                });

            }
        )

    </script>

@endsection
