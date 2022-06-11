@extends('CP.master')
@section('title')
    {{\App\Models\License::trans('plural')}}
@endsection
@section('content')

    <!-- start page title -->

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">الرئيسية</li>
                        <li class="breadcrumb-item"><a href="{{route('licenses')}}">{{\App\Models\License::crudTrans('index')}}</a></li>
                        <li class="breadcrumb-item active">{{\App\Models\License::crudTrans('create')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row ">
                        <div class="col-lg-12">
                            <h4>{{\App\Models\License::crudTrans('create')}}</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    <div class="row">
                        <form id="form" method="get" action="{{route('licenses.form')}}">
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label" for="raft_company_id">{{\App\Models\License::trans('raft_company_id')}}</label>
                                        <select class="form-select" id="raft_company_id" name="raft_company_id">
                                            <option value="">اختر...</option>
                                            <option value="service_provider">شركات حجاج الداخل</option>
                                            <option value="design_office">مكتب هندسي</option>
                                            <option value="Sharer">جهة مشاركة</option>
                                            <option value="consulting_office">مكتب استشاري</option>
                                            <option value="contractor">مقاول</option>
                                            <option value="taslem_maintenance">تسليم صيانة</option>
                                            <option value="raft_company">شركة طوافة</option>
                                            <option value="Delivery">تسليم</option>
                                            <option value="Kdana">كدانة</option>
                                        </select>
                                    </div>
                                    <div class="col-12 text-danger" id="raft_company_id_error"></div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <br>

                    </div>

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                <li>{{ $error }}</li>
                            </div>
                        @endforeach
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <li>{{ session('success') }}</li>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div style="z-index: 11">
        <div id="toast" class="toast overflow-hidden mt-3 fade hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="align-items-center text-white bg-danger border-0">
                <div class="d-flex">
                    <div class="toast-body">
                        Hello, world! This is a toast message.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    <script>

            $('#raft_company_id').change(function(e){
                $('#form').submit()
            })

    </script>
@endsection
