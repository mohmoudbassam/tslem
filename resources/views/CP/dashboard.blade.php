@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="h3">عدد المسجلين</span>
                            <h4 class="mb-3 mt-3">
                                <span class="counter-value" data-target="{{$number_of_user}}"></span>مستخدم
                            </h4>
                        </div>
                    </div>

                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span class="h4">عدد المستخدمين تحت الإعتماد</span>
                        </div>
                        <h4 class="mb-3 mt-3">
                            <span class="counter-value" data-target="{{$number_of_user_under_approve}}"></span>مستخدم
                        </h4>

                    </div>
                    <h4 class="mb-3">

                    </h4>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span class="h4">عدد المستخدمين المعتمدين</span>
                        </div>
                        <h4 class="mb-3 mt-3">
                            <span class="counter-value" data-target="{{$number_of_approve_user}}"></span>مستخدم
                        </h4>

                    </div>
                    <h4 class="mb-3">

                    </h4>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span class="h4">عدد مراكز الخدمة</span>
                        </div>
                        <h4 class="mb-3 mt-3">
                            <span class="counter-value" data-target="{{$number_of_service_providers}}"></span>مركز
                        </h4>

                    </div>
                    <h4 class="mb-3">

                    </h4>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span class="h4">عدد المقاولون</span>
                        </div>
                        <h4 class="mb-3 mt-3">
                            <span class="counter-value" data-target="{{$number_of_contractors}}"></span>مقاول
                        </h4>

                    </div>
                    <h4 class="mb-3">

                    </h4>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <span class="h4">عدد المكاتب الإستشارية</span>
                        </div>
                        <h4 class="mb-3 mt-3">
                            <span class="counter-value" data-target="{{$number_of_consulting_office}}"></span>مكتب
                        </h4>

                    </div>
                    <h4 class="mb-3">

                    </h4>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->


    </div>
@endsection

@section('scripts')
@endsection
