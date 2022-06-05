@extends('CP.sharer_layout')
@section('title')
    المواعيد
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('taslem_maintenance.index')}}">الرئيسية</a></li>
                                    <li class="breadcrumb-item active"><a href="{{route('taslem_maintenance.index')}}">إضافة موعد</a></li>
                                </ol>
                            </div>

                        </div>
                        <!-- end card body -->
                    </div>

            </div>
        </div>
    </div>
    <div class="card">

    <div class="card-header">
            <div class="row">
                <div class="col-lg-3 col-xxl-2">
                    <label for="camp_number">رقم المربع   </label>
                    <input type="text" class="form-control" name="camp_number" id="camp_number">
                </div>
                <div class="col-lg-3 col-xxl-2">
                    <label for="box_number">رقم المخيم</label>
                    <input type="text" class="form-control" name="box_number" id="box_number">
                </div>
                <div class="col-auto ms-auto" style="margin-top:1.9rem;">
                    <button type="submit" class="btn btn-primary search_btn"><i class="fa fa-search"></i></button>
                </div>

            </div>
        </div>

        <div class="card-body pb-0">

            <form id="add_edit_form" method="post" action="{{route('taslem_maintenance.sessions.save')}}" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                        id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                        role="grid"
                        aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <th>
                            الاسم
                        </th>
                        <th>
                            البريد الالكتروني
                        </th>
                        <th>
                        اسم المفوض
                        </th>
                        <th>
                            اختيار
                        </th>


                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                @csrf
                <div class="mb-3 mt-3">
                    <label for="start_at">وقت الموعد</label>
                    <div class="input-group auth-pass-inputgroup">
                        <input type="text" class="form-control datepicker" id="start_at" name="start_at">
                        <div class="btn btn-light shadow-none ms-0"><i class="far fa-clock"></i></div>
                    </div>
                    <div class="col-12 text-danger" id="start_at_error"></div>
                </div>
            </form>
        </div>
        <div class="card-body  border-top d-none" id="dateTimeView">
{{--            <div class="col-lg-8 fv-row">--}}
{{--                <div class="border rounded mt-5">--}}
{{--                    <ul class="list-unstyled row m-0 session_list">--}}

{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div id="dateTimeHiddenInput">--}}

{{--                </div>--}}

{{--            </div>--}}





            <div class="row">


            </div>
        </div>
        <div class="d-flex flex-wrap gap-3 mx-4 mt-3 mb-5">
            <button type="button" class="btn btn-lg btn-primary  px-4 submit_btn" >إنشاء</button>
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>
        $('.session_list').append('<li class="border-bottom py-3 col-6" id=""><i class="fa fa-jedi-order fa-fw"></i>    المركز :         &nbsp;&nbsp; &nbsp;سيبيسبسيبسيبس<i class="fa fa-clock fa-fw"></i> <i class="fa fa-calendar fa-fw"></i> شسي </li>');
         $('#add_session').on('click', function(){
             if($('.user_id:checkbox:checked').length){
                 $('.user_id:checkbox:checked').each(function(i){

                 });
                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                 });
                 $.ajax({
                     url : '{{route('read_message')}}',
                     data: {},
                     type: "POST",
                     processData: false,
                     contentType: false,
                     beforeSend(){
                         KTApp.block('#page_modal', {
                             overlayColor: '#000000',
                             type: 'v2',
                             state: 'success',
                             message: 'مكتب تصميم'
                         });
                     },
                     success:function(data) {
                         $('#notifcation_count').text('')
                         $('#unreade_meassage').text('')
                         KTApp.unblockPage();
                     },
                     error:function(data) {
                         console.log(data);
                         KTApp.unblock('#page_modal');
                         KTApp.unblockPage();
                     },
                 });
             }
         })

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
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });

        $('#add_edit_form').validate({
            rules: {
                "start_at": {
                    required: true,
                }, "user_id": {
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

            const formData = new FormData();
             if(!$("input:radio.user_id:checked").length){

                 showAlertMessage('error','الرجاء اختيار المستخدم')
                 return false;
             }
            formData.append("start_at", $('#start_at').val());
            formData.append("user_id", $("input:radio.user_id:checked").val());
            formData.append("_token", '{{ csrf_token() }}');

            postData(formData, '{{route('taslem_maintenance.sessions.save')}}');
        });

        flatpickr(".datepicker", { enableTime: true, minDate: '{{now('Asia/Riyadh')}}'});
    </script>

@endsection
