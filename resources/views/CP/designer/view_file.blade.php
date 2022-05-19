@extends('CP.master')
@section('title')
    الطلبات
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

        .krajee-default.file-preview-frame {
            margin: 8px;
            border: 1px solid rgba(0, 0, 0, .2);
            box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
            padding: 6px;
            float: left;
            width: 50%;
            text-align: center;
        }

        file-drop-zone clearfix {

        }
    </style>
@endsection
@section('content')

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
                <h2> مقدم الخدمة :{{$order->service_provider->name}}</h2>
            </div>
        </div>
        <div class="card-body">

            <div class="row">

                @foreach($order_specialties as $_specialties)

                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title">{{$_specialties[0]->service->specialties->name_ar}}</h4>

                        </div>

                        <div class="card-body">
                            @foreach($_specialties as $service)

                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="service_id">توصيف
                                                    الخدمة</label>
                                                <input type="text" disabled name="" id="" class="form-control req "
                                                       value="{{$service->service->name}}"
                                                       placeholder="">

                                            </div>
                                        </div>


                                        <div class="col-md-3 ">
                                            <div class="mb-3 unit_hide">
                                                <label
                                                    class="form-label">{{$service->service->unit}}</label>
                                                <input type="text" disabled name="" id="" class="form-control req "
                                                       value="{{$service->unit}}"
                                                       placeholder="">
                                                <div class="col-12 text-danger"
                                                     id="service_id_error"></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                            <div class="row mt-5">
                                @foreach($filess->where('specialties.name_en',$_specialties[0]->service->specialties->name_en) as $files)

                                    @if($files->type ==1)
                                        <div class="col-md-offset-3 col-md-2">
                                            <div class="panel panel-default bootcards-file">

                                                <div class="list-group">
                                                    <div class="list-group-item">
                                                        <a href="#">
                                                            <i class="fa fa-file-pdf fa-4x"></i>
                                                        </a>
                                                        <h5 class="list-group-item-heading">
                                                            <a href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                {{$files->real_name}}
                                                            </a>
                                                        </h5>

                                                    </div>
                                                    <div class="list-group-item">
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group">
                                                            <a class="btn btn-success" href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                <i class="fa fa-arrow-down"></i>
                                                                تنزيل
                                                            </a>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        @if($files->type ==2)
                                        <div class="col-md-offset-3 col-md-2">
                                            <div class="panel panel-default bootcards-file">

                                                <div class="list-group">
                                                    <div class="list-group-item">
                                                        <a href="{{route('design_office.download',['id'=>$files->id])}}">
                                                            <i class="fa fa-file-pdf fa-4x"></i>
                                                        </a>
                                                        <h5 class="list-group-item-heading">
                                                            <a href="#">
                                                                {{$files->real_name}}
                                                            </a>
                                                        </h5>

                                                    </div>
                                                    <div class="list-group-item">
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group">
                                                            <a class="btn btn-success" href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                <i class="fa fa-arrow-down"></i>
                                                                تنزيل
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        @if($files->type ==3)
                                        <div class="col-md-offset-3 col-md-2">
                                            <div class="panel panel-default bootcards-file">

                                                <div class="list-group">
                                                    <div class="list-group-item">
                                                        <a href="#">
                                                            <i class="fa fa-file-pdf fa-4x"></i>
                                                        </a>
                                                        <h5 class="list-group-item-heading">
                                                            <a href="#">
                                                                {{$files->real_name}}
                                                            </a>
                                                        </h5>

                                                    </div>
                                                    <div class="list-group-item">
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group">
                                                            <a class="btn btn-success" href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                <i class="fa fa-arrow-down" ></i>
                                                                تنزيل
                                                            </a>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    <script>

    </script>

@endsection

