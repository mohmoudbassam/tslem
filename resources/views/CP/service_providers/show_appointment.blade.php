@extends('CP.master')
@section('title')
    الموعد
@endsection
@section('style')
@endsection
@section('content')
    <style>
        .file-view-wrapper:hover {
            box-shadow: var(--bs-box-shadow) !important;
        }

        .file-view-icon {
            height: 180px;
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .file-view-wrapper{
            position: relative;
        }
        .file-view-download{
            position: absolute;
            top: 9px;
            left: 11px;
            font-size: 18px;
            color: #0b2473;
        }
    </style>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('services_providers.orders')}}">الطلبات</a></li>
                            <li class="breadcrumb-item active">الرئيسية</li>
                        </ol>
                    </div>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="tab-content">
                <div class="tab-pane active" id="overview" role="tabpanel">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">

                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-20">الموعد : </h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="h4">
                                                <p class="mb-2">{{$session->start_at}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div>
                                                <h5 class="font-size-15"></h5>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="h4">
                                                <p class="mb-2">{{\Carbon\Carbon::parse($session->start_at)->diffForHumans()}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>

                        <!-- end card body -->
                    </div>
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
                                    @foreach($files as $file)
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view"
                                             style="cursor:pointer;">
                                            <a href="{{route('services_providers.docx_file',['fileType'=>$file['url_type'])}}" target="_blank" class="w-100 rounded border overflow-hidden file-view-wrapper d-block">
                                                <div class="file-view-icon"
                                                     style="background-image: url('{{asset("assets/images/pdf-file.png")}}');"></div>
                                                     <div class="file-view-download"><i class="fas fa-download"></i></div>
                                                <div
                                                    class="p-2 justify-content-center d-flex flex-column text-center border-top"
                                                    style="background-color: #eeeeee;">
                                                    <small class="text-muted" id="file-view-name">{{$file['name']}}</small>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->


                    <!-- end card -->
                </div>
                <!-- end tab pane -->

                <div class="tab-pane" id="about" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end tab pane -->

                <!-- end tab pane -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end col -->


    </div>
@endsection

@section('scripts')

@endsection
