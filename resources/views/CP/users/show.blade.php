@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('style')
    <style>
        .close {
            color: #fff !important;
            visibility: hidden !important;
        }

        .file-caption-main {
            color: #fff !important;
            visibility: hidden !important;
        }
        .center-block {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
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

                                        <div
                                            class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                            @if($user->email)
                                                <div>
                                                    <i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{$user->email}}
                                                </div>
                                            @endif
                                            @if($user->co_type)
                                                <div>
                                                    <i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{$user->co_type}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">المعلومات
                                الإساسية</a>
                        </li>
                        @if($user->type == 'design_office' || $user->type == 'consulting_office' || $user->type == 'design_office' || $user->type=='service_provider' || $user->type=='contractor')

                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab" href="#about" role="tab">المعلومات
                                الثانوية</a>
                        </li>
                        @endif
                        @if($user->type == 'design_office' || $user->type == 'consulting_office' || $user->type == 'design_office')
                            <li class="nav-item">
                                <a class="nav-link px-3" data-bs-toggle="tab" href="#post" role="tab">معلومات المكان</a>
                            </li>
                        @endif
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
                                @if($user->type =='Kdana' || $user->type =='Delivery')
                                    <div class="pb-3">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <div>
                                                    <h5 class="font-size-15">اسم الشخص  المسؤول</h5>
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
                                                    <h5 class="font-size-15">رقم الجوال</h5>
                                                </div>
                                            </div>
                                            <div class="col-xl">
                                                <div class="text-muted">
                                                    <p class="mb-2">{{$user->phone}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                @if($user->type == 'design_office' || $user->type == 'consulting_office' || $user->type == 'design_office' || $user->type=='service_provider'|| $user->type=='contractor' )
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
                                @endif
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    @if($user->type == 'design_office' || $user->type == 'consulting_office' || $user->type == 'design_office' || $user->type=='service_provider'|| $user->type=='contractor')
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">الملفات</h5>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div>
                                <div class="row">
                                    @foreach(array_keys($col_file) as $_col_file)
                                        <div class="col-xl-3">
                                            <div class="card p-1 mb-xl-0">
                                                <div class="p-3">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="font-size-15 text-truncate"><a href="#"
                                                                                                      class="text-dark">{{file_name_by_column($_col_file)}}</a>
                                                            </h5>

                                                            @if($user->{$_col_file."_end_date"})
                                                                <p class="font-size-13 text-muted mb-0">تاريخ
                                                                    الإنتهاء {{ $user->{$_col_file."_end_date"} }}</p>
                                                            @endif

                                                        </div>
                                                        <div class="flex-shrink-0 ms-2">
                                                            <div class="dropdown">
                                                                <a class="btn btn-link text-muted font-size-16 p-1 py-0 dropdown-toggle shadow-none"
                                                                   href="#" role="button" data-bs-toggle="dropdown"
                                                                   aria-expanded="false">

                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="position-relative ">
                                                    @if(is_image(pathinfo($user->{$_col_file}, PATHINFO_EXTENSION)))
                                                        <a href="{{asset('storage/'.$user->{$_col_file})}}" class="align-self-xxl-end">
                                                            <img src="{{asset('storage/'.$user->{$_col_file})}}"
                                                                 class="img-thumbnail">
                                                        </a>
                                                    @endif

                                                    @if(is_pdf(pathinfo($user->{$_col_file}, PATHINFO_EXTENSION)))
                                                        @if(is_pdf(pathinfo($user->{$_col_file}, PATHINFO_EXTENSION)))
                                                            <a href="{{asset('storage/'.$user->{$_col_file})}}"  >
                                                                <img src="{{asset('storage/'.'pdf.jfif')}}" style="width: 30%;"
                                                                     class="center-block" >
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    @endif
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
                @if($user->type == 'design_office' || $user->type == 'consulting_office' || $user->type == 'design_office')
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

                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- end card -->
                    </div>
            @endif  <!-- end tab pane -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end col -->


    </div>
@endsection

@section('scripts')
    <script>
        @foreach(array_keys($col_file) as $_col)
        @if($user->{$_col})

        file_input_custom('#{{$_col}}', {
            initialPreview: '{{asset('storage/'.$user->{$_col})}}',
        });
        @else
        file_input_custom('#{{$_col}}');
        @endif

        @endforeach
        function file_input_custom(selector, options) {
            let defaults = {
                theme: "fas",
                showDrag: false,
                deleteExtraData: {
                    '_token': '{{csrf_token()}}',
                },
                browseClass: "btn btn-info",
                browseLabel: "",
                browseIcon: "<i class='la la-file'></i>",
                removeClass: "btn btn-danger",
                removeLabel: "delete",
                removeIcon: "<i class='la la-trash-o'></i>",
                showRemove: false,
                showCancel: false,
                showUpload: false,
                showPreview: true,
                msgPlaceholder: " ",
                msgSelected: " ",
                fileSingle: "one files",
                filePlural: "multi files",
                dropZoneTitle: " ",
                msgZoomModalHeading: " ",
                dropZoneClickTitle: '',
                initialPreview: [],
                initialPreviewShowDelete: false,
                initialPreviewAsData: true,
                initialPreviewConfig: [],
                initialPreviewFileType: 'image',
                overwriteInitial: true,
                browseOnZoneClick: true,
                maxFileCount: 6,
            };
            let settings = $.extend({}, defaults, options);
            $(selector).fileinput(settings);
        }

        $('.fileAction').on('click', function () {
            e.preventDefault();
            return false;
        })

    </script>
@endsection
