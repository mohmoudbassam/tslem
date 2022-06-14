@extends('CP.master')
@section('title')
    الملاحظات
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
            <!-- <div class="card">
                <div class="card-body">


                    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">الملاحظات والملفات
                            </a>
                        </li>
                    </ul>
                </div>
            </div> -->
            <!-- end card body -->
            <!-- end card -->

            <div class="tab-content">
                <div class="tab-pane active" id="overview" role="tabpanel">
                    <div class="card">

                        @if(isset($session->RaftCompanyBox) and !$session->RaftCompanyBox->seen_notes)
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">الملاحظات</h4>
                                    <form action="{{route('raft_company.seen_maintain_file',['session'=>$session->id])}}" method="get">
                                        <div>
                                            <button type="submit" class="btn btn-lg btn-primary submit_btn">تم الإطلاع</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <div class="card-body">
                            <p class="mb-2">{{$session->RaftCompanyBox->tasleem_notes}}</p>
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

                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view"
                                             style="cursor:pointer;">
                                            <a href="{{asset('storage/'.$session->RaftCompanyBox->file_first)}}" target="_blank" class="w-100 rounded border overflow-hidden file-view-wrapper d-block">
                                                <div class="file-view-icon"
                                                     style="background-image: url('{{asset("assets/images/pdf-file.png")}}');"></div>
                                                     <div class="file-view-download"><i class="fas fa-download"></i></div>
                                                <div
                                                    class="p-2 justify-content-center d-flex flex-column text-center border-top"
                                                    style="background-color: #eeeeee;">
                                                    <p class="text-muted mb-0" id="file-view-name">{{$session->RaftCompanyBox->file_first_name}}</p>
                                                </div>
                                            </a>
                                        </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view"
                                         style="cursor:pointer;">
                                        <a href="{{asset('storage/'.$session->RaftCompanyBox->file_second)}}" target="_blank" class="w-100 rounded border overflow-hidden file-view-wrapper d-block">
                                            <div class="file-view-icon"
                                                 style="background-image: url('{{asset("assets/images/pdf-file.png")}}');"></div>
                                                 <div class="file-view-download"><i class="fas fa-download"></i></div>
                                            <div
                                                class="p-2 justify-content-center d-flex flex-column text-center border-top"
                                                style="background-color: #eeeeee;">
                                                <p class="text-muted mb-0" id="file-view-name">{{$session->RaftCompanyBox->file_second_name}}</p>
                                            </div>
                                        </a>
                                    </div> <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view"
                                         style="cursor:pointer;">
                                        <a href="{{asset('storage/'.$session->RaftCompanyBox->file_third)}}" target="_blank" class="w-100 rounded border overflow-hidden file-view-wrapper d-block">
                                            <div class="file-view-icon"
                                                 style="background-image: url('{{asset("assets/images/pdf-file.png")}}');"></div>
                                                 <div class="file-view-download"><i class="fas fa-download"></i></div>
                                            <div
                                                class="p-2 justify-content-center d-flex flex-column text-center border-top"
                                                style="background-color: #eeeeee;">
                                                <p class="text-muted mb-0" id="file-view-name">{{$session->RaftCompanyBox->file_third_name}}</p>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                                <div class="row">



                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- <div class="row text-end pb-4" style="margin-top:1.9rem; margin-left: 30px">
                            <form action="{{route('raft_company.seen_maintain_file',['session'=>$session->id])}}" method="get">
                                <div>
                                    <button type="submit" class="btn btn-lg btn-primary submit_btn">تم الإطلاع</button>
                                </div>
                            </form>

                        </div> -->
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
