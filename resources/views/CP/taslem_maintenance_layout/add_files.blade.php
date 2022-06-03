@extends('CP.sharer_layout')
@section('title')
    المواعيد
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

    <!-- start page title -->
    <!-- <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">

            </div>
        </div>
    </div> -->

    <div class="card">

        <div class="card-header">
            <h4 class="mb-sm-0 font-size-18">إضافة الملفات</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 my-3">
                    <p ><span class="bold">  الشركة : </span>{{$user->company_name}}</p>
                </div>

                <div class="col-md-6 my-3 text-lg-end">
                    <p ><span class="bold">  الموعد :</span>{{$session->start_at}} </p>
                </div>


            </div>
            <form action="{{route('taslem_maintenance.save_note')}}" method="post" enctype="multipart/form-">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="dropzone">
                            <div id="dropzone_first_file">
                                <div class="fallback">
                                    <input name="first_file" type="file" id="first_file">
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
                        <div class="dropzone">
                            <div id="dropzone_seconde_file">
                                <div class="fallback">
                                    <input name="dropzone_seconde_file" type="file" id="dropzone_seconde_file">
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
                        <div class="dropzone">

                            <div id="dropzone_third_file">
                                <div class="fallback">
                                    <input name="dropzone_third_file" type="file" id="dropzone_third_file">
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
                        rows="10">{{$user->service_provider_note}}</textarea>
                        <div class="text-danger" id="note_error"></div>
                </div>
                <input type="hidden" id="service_provider_id" name="service_provider_id" value="{{$user->id}}">

                <div class=" text-end" style="margin-top:1.9rem;">
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

                $('#dropzone_first_file').dropzone({
                    url: "{{route('taslem_maintenance.upload_file',['service_provider_id'=>$user->id,'type'=>1])}}",
                    paramName: "file", // The name that will be used to transfer the file
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (file, response) {

                        uploadAttachmentsArArray.push(response.success); // uploaded image name
                        console.log('upload_attachments_ar_arr', uploadAttachmentsArArray);
                        $('#upload_attachments_ar_arr').val(JSON.stringify(uploadAttachmentsArArray));

                    },

                });
                $('#dropzone_seconde_file').dropzone({
                    url: "{{route('taslem_maintenance.upload_file',['service_provider_id'=>$user->id,'type'=>2])}}",
                    paramName: "file", // The name that will be used to transfer the file
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (file, response) {

                        uploadAttachmentsArArray.push(response.success); // uploaded image name
                        console.log('upload_attachments_ar_arr', uploadAttachmentsArArray);
                        $('#upload_attachments_ar_arr').val(JSON.stringify(uploadAttachmentsArArray));

                    },

                }); $('#dropzone_third_file').dropzone({
                    url: "{{route('taslem_maintenance.upload_file',['service_provider_id'=>$user->id,'type'=>3])}}",
                    paramName: "file", // The name that will be used to transfer the file
                    maxFiles: 10,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (file, response) {

                        uploadAttachmentsArArray.push(response.success); // uploaded image name
                        console.log('upload_attachments_ar_arr', uploadAttachmentsArArray);
                        $('#upload_attachments_ar_arr').val(JSON.stringify(uploadAttachmentsArArray));

                    },

                });
            }
        )
        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route('taslem_maintenance.sessions.users_list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.camp_number = $('#camp_number').val();
                        d.box_number = $('#box_number').val();
                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'company_name', name: 'company_name'},
                    {className: 'text-center', data: 'email', name: 'email'},
                    {className: 'text-center', data: 'company_owner_name', name: 'company_owner_name'},
                    {className: 'text-center', data: 'actions', name: 'actions'},
                ],


            });

        });


        flatpickr(".datepicker", {enableTime: true, minDate: '{{now('Asia/Riyadh')}}'});
    </script>

@endsection
