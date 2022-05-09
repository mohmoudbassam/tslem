@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm order-2 order-sm-1">
                            <div class="d-flex align-items-start mt-3 mt-sm-0">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xl me-3">
                                        <img src="{{$user->image}}" alt="" class="img-fluid rounded-circle d-block">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-16 mb-1">{{$user->name}}</h5>
                                        <p class="text-muted font-size-13">{{$user->user_type}}</p>

                                        <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                            <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{$user->email}}</div>
                                            <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{$user->co_type}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">المعلومات الإساسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab" href="#about" role="tab">المعلومات الثانوية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab" href="#post" role="tab">معلومات المكان</a>
                        </li>
                    </ul>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="tab-content">
                <div class="tab-pane active" id="overview" role="tabpanel">
                    <div class="card">

                        <div class="card-body">
                            <div>
                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15">اسم مدير الشركة</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="text-muted">
                                                <p class="mb-2">{{$user->company_owner_name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="py-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15">رقم السجل التجاري</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="text-muted">
                                                <p class="mb-2">{{$user->commercial_record}}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="py-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15">الموقع</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="text-muted">
                                                <p class="mb-2">{{$user->website}}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Post</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="#post">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="card p-1 mb-xl-0">
                                            <div class="p-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-15 text-truncate"><a href="#" class="text-dark">Beautiful Day with Friends</a></h5>
                                                        <p class="font-size-13 text-muted mb-0">10 Apr, 2020</p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="dropdown">
                                                            <a class="btn btn-link text-muted font-size-16 p-1 py-0 dropdown-toggle shadow-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="position-relative">
                                                <img src="assets/images/small/img-3.jpg" alt="" class="img-thumbnail">
                                            </div>

                                            <div class="p-3">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-3">
                                                        <a href="javascript: void(0);" class="text-muted">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> Project
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        <a href="javascript: void(0);" class="text-muted">
                                                            <i class="bx bx-comment-dots align-middle text-muted me-1"></i> 12 Comments
                                                        </a>
                                                    </li>
                                                </ul>
                                                <p class="text-muted">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet</p>

                                                <div>
                                                    <a href="javascript: void(0);" class="text-primary">Read more <i class="mdi mdi-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-xl-4">
                                        <div class="card p-1 mb-xl-0">
                                            <div class="p-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-15 text-truncate"><a href="#" class="text-dark">Drawing a sketch</a></h5>
                                                        <p class="font-size-13 text-muted mb-0">24 Mar, 2020</p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="dropdown">
                                                            <a class="btn btn-link text-muted font-size-16 p-1 py-0 dropdown-toggle shadow-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="position-relative">
                                                <img src="assets/images/small/img-1.jpg" alt="" class="img-thumbnail">
                                            </div>

                                            <div class="p-3">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-3">
                                                        <a href="javascript: void(0);" class="text-muted">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> Development
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        <a href="javascript: void(0);" class="text-muted">
                                                            <i class="bx bx-comment-dots align-middle text-muted me-1"></i> 08 Comments
                                                        </a>
                                                    </li>
                                                </ul>
                                                <p class="text-muted">At vero eos et accusamus et iusto odio dignissimos ducimus quos</p>

                                                <div>
                                                    <a href="javascript: void(0);" class="text-primary">Read more <i class="mdi mdi-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!-- end col -->

                                    <div class="col-xl-4">
                                        <div class="card p-1 mb-sm-0">
                                            <div class="p-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-15 text-truncate"><a href="#" class="text-dark">Project discussion with team</a></h5>
                                                        <p class="font-size-13 text-muted mb-0">20 Mar, 2020</p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="dropdown">
                                                            <a class="btn btn-link text-muted font-size-16 p-1 py-0 dropdown-toggle shadow-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="position-relative">
                                                <img src="assets/images/small/img-5.jpg" alt="" class="img-thumbnail">
                                            </div>

                                            <div class="p-3">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item me-3">
                                                        <a href="javascript: void(0);" class="text-muted">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> Project
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        <a href="javascript: void(0);" class="text-muted">
                                                            <i class="bx bx-comment-dots align-middle text-muted me-1"></i> 08 Comments
                                                        </a>
                                                    </li>
                                                </ul>
                                                <p class="text-muted">Itaque earum rerum hic tenetur a sapiente delectus ut aut</p>

                                                <div>
                                                    <a href="javascript: void(0);" class="text-primary">Read more <i class="mdi mdi-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end tab pane -->

                <div class="tab-pane" id="about" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15">اسم الشخص المسؤول</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="text-muted">
                                                <p class="mb-2">{{$user->responsible_name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15">رقم الهوية</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="text-muted">
                                                <p class="mb-2">{{$user->id_number}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15">تاريخ الإنتهاء</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="text-muted">
                                                <p class="mb-2">{{$user->id_date}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15">المصدر</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="text-muted">
                                                <p class="mb-2">{{$user->source}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end tab pane -->

                <div class="tab-pane" id="post" role="tabpanel">
                    <div class="card">

                        <div class="card-body">
                            <div>
                                <div>
                                    <div class="pb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <div>
                                                    <h5 class="font-size-15">العنوان</h5>
                                                </div>
                                            </div>
                                            <div class="col-xl">
                                                <div class="text-muted">
                                                    <p class="mb-2">{{$user->address}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="pb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <div>الجوال</div>
                                            </div>
                                            <div class="col-xl">
                                                <div class="text-muted">
                                                    <p class="mb-2">{{$user->phone}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="pb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <div>الهاتف</div>
                                            </div>
                                            <div class="col-xl">
                                                <div class="text-muted">
                                                    <p class="mb-2">{{$user->telephone}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr> <div class="pb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <div>المدينة</div>
                                            </div>
                                            <div class="col-xl">
                                                <div class="text-muted">
                                                    <p class="mb-2">{{$user->city}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="pb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <div>عدد الموظفين</div>
                                            </div>
                                            <div class="col-xl">
                                                <div class="text-muted">
                                                    <p class="mb-2">{{$user->city}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- end card -->
                </div>
                <!-- end tab pane -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end col -->



    </div>
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
                    url: '{{route('users.list')}}',
                    type: 'GET',
                    "data": function (d) {
                        d.name = $('#name').val();
                        d.type = $('#type').val();

                    }
                },
                language: {
                    "url": "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {className: 'text-center', data: 'name', name: 'name'},
                    {className: 'text-center', data: 'email', name: 'email'},
                    {className: 'text-center', data: 'type', name: 'type'},
                    {className: 'text-center', data: 'phone', name: 'phone'},
                    {className: 'text-center', data: 'enabled', name: 'enabled'},
                    {className: 'text-center', data: 'actions', name: 'actions'},


                ],


            });

        });
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false);
        });

        function delete_user(id, url, callback = null) {
            Swal.fire({
                title: 'هل انت متاكد من حذف المستخدم؟',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#84dc61',
                cancelButtonColor: '#d33',
                confirmButtonText: 'تأكيد',
                cancelButtonText: 'لا'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id
                        },
                        beforeSend() {
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                type: 'v2',
                                state: 'success',
                                message: 'الرجاء الانتظار'
                            });
                        },
                        success: function (data) {
                            if (callback && typeof callback === "function") {
                                callback(data);
                            } else {
                                if (data.success) {
                                    $('#items_table').DataTable().ajax.reload(null, false);
                                    showAlertMessage('success', data.message);
                                } else {
                                    showAlertMessage('error', 'هناك خطأ ما');
                                }
                                KTApp.unblockPage();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
                }
            });
        }
    </script>

@endsection
