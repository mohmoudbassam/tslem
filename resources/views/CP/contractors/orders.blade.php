@extends('CP.master')
@section('title')
    الطلبات
@endsection
@section('content')

    <style>
        .select2-selection__rendered {
            line-height: 36px !important;
        }
        .select2-container .select2-selection--single {
            height: 41px !important;
        }
        .select2-selection__arrow {
            height: 39px !important;
        }
    </style>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
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

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0 row-cols-md-4 row-cols-sm-3 row-cols-lg-4 row-cols-2">

                        <div class="col-lg-2">
                            <label for="order_identifier">رقم الطلب </label>
                            <input type="text" class="form-control" id="order_identifier" placeholder="رقم الطلب">
                        </div>


                        <div class="col-lg-2">
                            <label for="service_provider_id">شركات حجاج الداخل</label>
                            <select class="form-control" id="service_provider_id" name="service_provider_id">
                                <option value="">اختر...</option>
                                @foreach($service_providers as $services_provider)
                                    <option value="{{$services_provider->id}}">{{$services_provider->company_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="designer_id"> المكتب الهندسي</label>
                            <select class="form-control" id="designer_id" name="designer_id">
                                <option value="">اختر...</option>
                                @foreach($designers as $designer)
                                    <option value="{{$designer->id}}">{{$designer->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="consulting_id">المشرف</label>
                            <select class="form-control" id="consulting_id" name="consulting_id">
                                <option value="">اختر...</option>
                                @foreach($consulting as $_consulting)
                                    <option value="{{$_consulting->id}}">{{$_consulting->company_name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-lg-1">
                            <label for="from_date">من </label>
                            <input type="text" class="form-control datepicker" id="from_date" placeholder="">
                        </div>
                        <div class="col-lg-1">
                            <label for="to_date">الى </label>
                            <input type="text" class="form-control datepicker" id="to_date" placeholder="">
                        </div>

                        <!-- <div class="col-sm-auto" style="margin-top:1.9rem;">
                            <button type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i>بحث</button>
                        </div> -->
                        <div class="col-sm-auto ms-auto text-end" style="margin-top:1.9rem;">
                            <button type="button" class="btn btn-primary search_btn px-4 me-2"><i class="fa fa-search ms-1"></i>بحث
                            </button>
                            <button type="button" class="btn btn-danger reset_btn px-4"><i class="fa fa-times me-1"></i>إلغاء
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                           id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                           role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <th>
                            رقم الطلب
                        </th>
                        <th>
                            مقدم الخدمة
                        </th>
                        <th>
                           مكتب التصميم
                        </th>
                        <th>
                            التاريخ
                        </th>
                        <th>
                            حالة الطلب
                        </th>
                        <th>
                            تاريخ الإنشاء
                        </th>
                        <th>
                            الخيارات
                        </th>


                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>

    </div>
    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

    @if(auth()->user()->type == "contractor" and auth()->user()->contractor_types()->count() == 0)
        <div class="modal fade" id="choose-contractor-specialty-modal" tabindex="-1" role="dialog" aria-labelledby="choose-contractor-specialty-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choose-contractor-specialty-modal-title">اختيار التخصص</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle">
                                        من فضلك قم بإختيار التخصص الخاص بك
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label required-field" for="contractor-specialty">التخصص</label>
                                    <select class="form-control select2" name="contractor_specialty" id="contractor-specialty" required>
                                        <option value="1">عام</option>
                                        <option value="2">الوقاية والحماية من الحرائق</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" id="submit-contractor-specialty-btn" class="btn btn-primary" data-dismiss="modal">موافق</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>


        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#items_table').DataTable({
                "dom": 'tpi',
                "searching": false,
                "processing": true,
                'stateSave': true,
                "serverSide": true,
                ajax: {
                    url: '{{route('contractor.list')}}',
                    type: 'GET',
                    "data": function (d) {

                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();

                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'identifier', name: 'identifier'},
                    {className: 'text-center', data: 'service_provider.company_name', name: 'company_name',orderable : false},
                    {className: 'text-center', data: 'designer.company_name', name: 'company_name',orderable : false},
                    {className: 'text-center space-nowrap', data: 'date', name: 'date',orderable : false},
                    {className: 'text-center', data: 'order_status', name: 'order_status',orderable : false},
                    {className: 'text-center space-nowrap', data: 'created_at', name: 'created_at'},
                    {className: 'text-center', data: 'actions', name: 'actions',orderable : false},
                ],


            });

        });
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });
        flatpickr(".datepicker");
        function accept(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '',
                data: {
                    id: id
                },
                type: "POST",

                beforeSend() {
                    KTApp.block('#page_modal', {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'مكتب تصميم'
                    });
                },
                success: function (data) {
                    if(data.success){
                        showAlertMessage('success', data.message);
                    }else {
                        showAlertMessage('error', 'حدث خطأ في النظام');
                    }

                    KTApp.unblockPage();
                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في النظام');
                    KTApp.unblockPage();
                },
            });
        }



    </script>

    @if(auth()->user()->type == "contractor" and auth()->user()->contractor_types()->count() == 0)
        <script>
            $(function () {
                // $('.select2').select2({
                //     width: "100%",
                // });
                $("#choose-contractor-specialty-modal").modal({backdrop: 'static', keyboard: false});
                $("#choose-contractor-specialty-modal").modal("show");

                async function update_contractor_specialty(specialty) {
                    let response = await fetch("/contractor/update_specialty", {
                        method: "POST",
                        body: JSON.stringify({
                            specialty_id: specialty
                        }),
                        headers: {
                            'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                    });

                    return await (await response).json();
                }

                $("#submit-contractor-specialty-btn").on("click", async function (event) {
                    event.preventDefault();

                    let specialty = $("#contractor-specialty").val();
                    let response = await update_contractor_specialty(specialty);

                    if ( response['success'] ) {
                        showAlertMessage("success", response['message']);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showAlertMessage("error", response['message']);
                    }
                });
            })
        </script>
    @endif
@endsection
