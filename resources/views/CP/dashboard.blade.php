@extends('CP.master')
@section('title')
    الاحصائيات
@endsection
@section('style')
    <link href="{{url('/')}}/assets/index_files/all.min.css" rel="stylesheet">
    <!-- plugin css -->
    <link href="{{url('/')}}/assets/index_files/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{url('/')}}/assets/index_files/preloader.min.css" type="text/css">
    <link rel="stylesheet" href="{{url('/')}}/assets/index_files/custom-panel.css" type="text/css">

    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/assets/index_files/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{url('/')}}/assets/index_files/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{url('/')}}/assets/index_files/app-rtl-3.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/assets/index_files/fileinput.min.css" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/assets/index_files/alertify.min.css" rel="stylesheet" type="text/css">

    <!-- alertifyjs default themes  Css -->
    <link href="{{url('/')}}/assets/index_files/default.min.css" rel="stylesheet" type="text/css">

    <script src="{{url('/')}}/assets/index_files/sweetalert2.all.min.js.download"></script>
    <link rel="stylesheet" href="{{url('/')}}/assets/deshboard/style.css">
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="row justify-content-center">

            <div class="col-xl-4 col-md-6">
                <div class="card card-h-100 card-chart card-chart__filled card-chart__filled--blue">
                    <div class="card-body px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="_x3C_Layer_x3E_" version="1.1" xml:space="preserve"><g id="clipboard"><g><g><g><path d="M26.5,3h-5.958v1H26.5C26.776,4,27,4.225,27,4.5v25c0,0.275-0.224,0.5-0.5,0.5h-21      C5.224,30,5,29.775,5,29.5v-25C5,4.225,5.224,4,5.5,4h6V3h-6C4.673,3,4,3.673,4,4.5v25C4,30.327,4.673,31,5.5,31h21      c0.827,0,1.5-0.673,1.5-1.5v-25C28,3.673,27.327,3,26.5,3z" fill="currentColor"/></g></g><g><path d="M25.5,22c-0.276,0-0.5-0.224-0.5-0.5V6h-2.5C22.224,6,22,5.776,22,5.5S22.224,5,22.5,5h3     C25.776,5,26,5.224,26,5.5v16C26,21.776,25.776,22,25.5,22z" fill="currentColor"/></g><g><path d="M20.5,29h-14C6.224,29,6,28.776,6,28.5v-23C6,5.224,6.224,5,6.5,5h3C9.776,5,10,5.224,10,5.5     S9.776,6,9.5,6H7v22h13.5c0.276,0,0.5,0.224,0.5,0.5S20.776,29,20.5,29z" fill="currentColor"/></g><g><path d="M20.5,29c-0.064,0-0.129-0.013-0.191-0.038C20.122,28.885,20,28.702,20,28.5v-5     c0-0.276,0.224-0.5,0.5-0.5h5c0.202,0,0.385,0.122,0.462,0.309c0.078,0.187,0.035,0.402-0.108,0.545l-5,5     C20.758,28.949,20.63,29,20.5,29z M21,24v3.293L24.293,24H21z" fill="currentColor"/></g><g id="customer_survey_questionnaire_2_"><g><g><path d="M9.653,18.016c-0.004,0-0.007,0-0.011,0c-0.142-0.003-0.276-0.066-0.368-0.174l-1.153-1.346       c-0.18-0.209-0.156-0.525,0.054-0.705c0.21-0.18,0.526-0.154,0.705,0.055l0.791,0.922l1.59-1.693       c0.189-0.201,0.505-0.211,0.707-0.021s0.211,0.506,0.022,0.707l-1.972,2.099C9.923,17.959,9.791,18.016,9.653,18.016z" fill="currentColor"/></g></g><g><g><path d="M9.653,13.016c-0.004,0-0.007,0-0.011,0c-0.142-0.003-0.276-0.066-0.368-0.174l-1.153-1.346       c-0.18-0.209-0.156-0.525,0.054-0.705c0.21-0.18,0.526-0.154,0.705,0.055l0.791,0.922l1.59-1.693       c0.189-0.201,0.505-0.211,0.707-0.021s0.211,0.506,0.022,0.707l-1.972,2.099C9.923,12.959,9.791,13.016,9.653,13.016z" fill="currentColor"/></g></g><g><g><path d="M17.5,23h-4c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h4c0.276,0,0.5,0.224,0.5,0.5       S17.776,23,17.5,23z" fill="currentColor"/></g></g><g><g><path d="M22.5,21h-9c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h9c0.276,0,0.5,0.224,0.5,0.5       S22.776,21,22.5,21z" fill="currentColor"/></g></g><g><g><path d="M22.5,16h-3c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h3c0.276,0,0.5,0.224,0.5,0.5       S22.776,16,22.5,16z" fill="currentColor"/></g></g><g><g><path d="M20.5,18h-7c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h7c0.276,0,0.5,0.224,0.5,0.5       S20.776,18,20.5,18z" fill="currentColor"/></g></g><g><g><path d="M17.5,16h-4c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h4c0.276,0,0.5,0.224,0.5,0.5       S17.776,16,17.5,16z" fill="currentColor"/></g></g><g><g><path d="M22.5,11h-9c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h9c0.276,0,0.5,0.224,0.5,0.5       S22.776,11,22.5,11z" fill="currentColor"/></g></g><g><g><path d="M18.5,13h-5c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h5c0.276,0,0.5,0.224,0.5,0.5       S18.776,13,18.5,13z" fill="currentColor"/></g></g><g><g><path d="M10.5,23h-2C8.224,23,8,22.776,8,22.5v-2C8,20.224,8.224,20,8.5,20h2c0.276,0,0.5,0.224,0.5,0.5v2       C11,22.776,10.776,23,10.5,23z M9,22h1v-1H9V22z" fill="currentColor"/></g></g></g></g><g><path d="M20.5,7h-9C11.224,7,11,6.776,11,6.5v-3C11,2.673,11.673,2,12.5,2C12.776,2,13,2.224,13,2.5    S12.776,3,12.5,3C12.224,3,12,3.225,12,3.5V6h8V3.5C20,3.225,19.776,3,19.5,3C19.224,3,19,2.776,19,2.5S19.224,2,19.5,2    C20.327,2,21,2.673,21,3.5v3C21,6.776,20.776,7,20.5,7z" fill="currentColor"/></g><g><path d="M17.5,3C17.224,3,17,2.776,17,2.5C17,2.225,16.776,2,16.5,2h-1c-0.108,0-0.211,0.033-0.296,0.097    C15.074,2.192,15,2.339,15,2.5C15,2.776,14.776,3,14.5,3S14,2.776,14,2.5c0-0.475,0.228-0.926,0.609-1.207    C14.867,1.102,15.176,1,15.5,1h1C17.327,1,18,1.673,18,2.5C18,2.776,17.776,3,17.5,3z" fill="currentColor"/></g></g></svg>
                        <h3>عدد الطلبات</h3>
                        <p> {{$order_count}}    طلب </p>
                        <a href="{{route('orders')}}">عرض الطلبات</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-h-100 card-chart card-chart__filled card-chart__filled--brown">
                    <div class="card-body px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="Layer_1" version="1.1" xml:space="preserve"><g id="communication"><path d="M21.504,17c-0.056,0-0.112-0.01-0.167-0.029c-0.2-0.07-0.333-0.259-0.333-0.471V13h-5   c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h5.5c0.276,0,0.5,0.224,0.5,0.5v2.592l2.362-2.907   C24.461,12.067,24.604,12,24.754,12h4.75c0.275,0,0.5-0.225,0.5-0.5v-9c0-0.275-0.225-0.5-0.5-0.5h-25c-0.275,0-0.5,0.225-0.5,0.5   v9c0,0.275,0.225,0.5,0.5,0.5h1.5c0.276,0,0.5,0.224,0.5,0.5S6.28,13,6.004,13h-1.5c-0.827,0-1.5-0.673-1.5-1.5v-9   c0-0.827,0.673-1.5,1.5-1.5h25c0.827,0,1.5,0.673,1.5,1.5v9c0,0.827-0.673,1.5-1.5,1.5h-4.512l-3.101,3.815   C21.795,16.935,21.651,17,21.504,17z" fill="currentColor"/><g><g><path d="M18.644,17.674l-4.762-1.652l-0.295-2.355c-0.239,0.106-0.516,0.168-0.833,0.168     c-0.056,0-0.103-0.012-0.155-0.016l0.329,2.635c0.023,0.189,0.152,0.349,0.332,0.41l5.055,1.756     c0.9,0.314,1.689,1.427,1.689,2.381v4.493c0,0.276,0.224,0.5,0.5,0.5s0.5-0.224,0.5-0.5V21     C21.004,19.621,19.945,18.129,18.644,17.674z" fill="currentColor"/></g><g><path d="M1.504,25.993c-0.276,0-0.5-0.224-0.5-0.5V21c0-1.379,1.059-2.871,2.359-3.326l4.762-1.641l0.063-0.512     c0.034-0.274,0.289-0.465,0.559-0.434c0.273,0.034,0.468,0.284,0.434,0.559l-0.103,0.82c-0.023,0.189-0.153,0.348-0.333,0.41     l-5.054,1.742C2.793,18.934,2.004,20.047,2.004,21v4.493C2.004,25.77,1.78,25.993,1.504,25.993z" fill="currentColor"/></g><g><path d="M11.004,30.961c-0.083,0-0.167-0.021-0.242-0.063l-6.5-3.591c-0.16-0.089-0.259-0.257-0.258-0.44     l0.019-3.346c0.002-0.275,0.229-0.543,0.503-0.496c0.276,0.001,0.499,0.227,0.497,0.502l-0.017,3.049l6.007,3.319l5.991-3.06     v-3.313c0-0.276,0.224-0.5,0.5-0.5s0.5,0.224,0.5,0.5v3.619c0,0.188-0.105,0.36-0.272,0.445l-6.5,3.319     C11.16,30.943,11.082,30.961,11.004,30.961z" fill="currentColor"/></g><g><g><path d="M11.004,7c-0.943,0-1.68-0.172-2.131-0.317C8.609,6.598,8.465,6.316,8.549,6.054      C8.634,5.791,8.914,5.647,9.178,5.73C9.562,5.854,10.189,6,11.004,6c1.808,0,2.774-0.446,2.784-0.451      c0.248-0.115,0.547-0.014,0.666,0.236c0.118,0.248,0.016,0.545-0.232,0.664C14.176,6.473,13.063,7,11.004,7z" fill="currentColor"/></g><g><path d="M11.004,15c-2.779,0-4.192-2.344-4.201-6.969C6.801,6.857,6.926,5.168,8.029,4.063      C8.733,3.357,9.733,3,11.004,3s2.271,0.357,2.975,1.063c1.104,1.105,1.229,2.795,1.227,3.969C15.196,12.656,13.783,15,11.004,15      z M11.004,4c-1.009,0-1.75,0.252-2.267,0.769C8.105,5.401,7.8,6.469,7.803,8.029C7.811,12.047,8.857,14,11.004,14      s3.193-1.953,3.201-5.971c0.003-1.561-0.303-2.628-0.935-3.261C12.754,4.252,12.013,4,11.004,4z" fill="currentColor"/></g></g></g><path d="M22.504,9h-4c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h4c0.276,0,0.5,0.224,0.5,0.5S22.78,9,22.504,9z   " fill="currentColor"/><path d="M27.504,6h-9c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h9c0.276,0,0.5,0.224,0.5,0.5S27.78,6,27.504,6z   " fill="currentColor"/></g></svg>
                        <h3>عدد الرخص الصادرة</h3>
                        <p>0 رخصة</p>
                        <a href="#">عرض الرخص</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-h-100 card-chart card-chart__filled card-chart__filled--lighbrown">
                    <div class="card-body px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="_x3C_Layer_x3E_" version="1.1" xml:space="preserve"><g id="folder"><g><path d="M29.5,7h-18c-0.167,0-0.323-0.084-0.416-0.223L9.639,4.609C9.426,4.29,8.884,4,8.5,4h-5    C3.224,4,3,4.225,3,4.5v2C3,6.776,2.776,7,2.5,7S2,6.776,2,6.5v-2C2,3.673,2.673,3,3.5,3h5c0.723,0,1.571,0.453,1.971,1.055    L11.768,6H29.5C29.776,6,30,6.224,30,6.5S29.776,7,29.5,7z" fill="currentColor"/></g><g><g><path d="M29.5,30h-27C1.673,30,1,29.327,1,28.5v-19C1,8.673,1.673,8,2.5,8h27C30.327,8,31,8.673,31,9.5v19     C31,29.327,30.327,30,29.5,30z M2.5,9C2.224,9,2,9.225,2,9.5v19C2,28.775,2.224,29,2.5,29h27c0.276,0,0.5-0.225,0.5-0.5v-19     C30,9.225,29.776,9,29.5,9H2.5z" fill="currentColor"/></g></g><g><g><path d="M25.5,28h-24C1.224,28,1,27.776,1,27.5S1.224,27,1.5,27h24c0.276,0,0.5,0.224,0.5,0.5S25.776,28,25.5,28z     " fill="currentColor"/></g></g><g><g><path d="M13.5,13h-9C4.224,13,4,12.776,4,12.5S4.224,12,4.5,12h9c0.276,0,0.5,0.224,0.5,0.5S13.776,13,13.5,13z" fill="currentColor"/></g></g><g><g><path d="M9.5,15h-5C4.224,15,4,14.776,4,14.5S4.224,14,4.5,14h5c0.276,0,0.5,0.224,0.5,0.5S9.776,15,9.5,15z" fill="currentColor"/></g></g><g><circle cx="27.5" cy="27.5" fill="currentColor" r="0.5"/></g></g></svg>
                        <h3>المخيمات تحت التنفيد</h3>
                        <p>{{$not_complete_orders}}  مخيم </p>
                        <a href="#">عرض المخيمات</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-12">
                <div class="card card-chart">
                    <div class="card-body px-2">
                        <h3 class="custom-stats-title">احصائيات المخيمات</h3>
                        <ul class="custom-stats">
                            <li>
                                <p>
                                    <label><i class="bg-blue-dark"></i>المخيمات تحت التنفيد</label>
                                    <span>{{$not_complete_orders}}   مخيم </span>
                                </p>
                                <p>
                                    <label><i class="bg-blue-light"></i>المخيمات تم تنفيذها</label>
                                    <span>{{$complete_orders}}      مخيم  </span>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar bg-blue-dark" role="progressbar" style="width: 70%" aria-valuenow="{{number_format($not_complete_orders/$all_order,1)}}" aria-valuemin="0" aria-valuemax="100">{{number_format(($not_complete_orders/$all_order)*100,1)}}%</div>
                                    <div class="progress-bar bg-blue-light" role="progressbar" style="width: 30%" aria-valuenow="{{number_format($complete_orders/$all_order,1)}}" aria-valuemin="0" aria-valuemax="100">{{number_format(($complete_orders/$all_order)*100,1)}}%</div>
                                </div>

                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card card-chart">
                    <div class="card-body px-2">
                        <h3 class="custom-stats-title">احصائيات الرخص</h3>
                        <ul class="custom-stats">
                            <li>
                                <p>
                                    <label><i class="bg-brown-dark"></i>عدد الرخص الصادرة - التنفيذ</label>
                                    <span>0 رخصة</span>
                                </p>
                                <p>
                                    <label><i class="bg-brown-light"></i>عدد الرخص الصادرة - التشغيل</label>
                                    <span>0 رخصة</span>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar bg-brown-dark" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
                                    <div class="progress-bar bg-brown-light" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                                </div>

                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-xl-6 col-md-12">
                <div class="card card-h-100 card-chart">
                    <div class="card-body px-2">
                        <h3 class="custom-stats-title">المخيمات التى تم استلامها</h3>
                        <div id="barchart-1" style="min-height: 160px;">

                        </div>
                    </div>
                </div>
            </div>

        </div>

{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="card card-h-100 card-chart">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body px-2">--}}
{{--                    <div id="chart-1"></div>--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col -->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="card card-h-100 card-chart">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body px-2">--}}
{{--                    <div id="chart-2"></div>--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col -->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="card card-h-100 card-chart">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body px-2">--}}
{{--                    <div id="chart-3"></div>--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div>--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="card card-h-100 card-chart">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body px-2">--}}
{{--                    <div id="chart-7"></div>--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div>--}}

{{--      <!-- end col -->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="card card-h-100 card-chart">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body px-2">--}}
{{--                    <div id="chart-4"></div>--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col -->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="card card-h-100 card-chart">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body px-2">--}}
{{--                    <div id="chart-5"></div>--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col -->--}}
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-xl-12 col-xxl-12 col-md-12">--}}
{{--            <!-- card -->--}}
{{--            <div class="card card-h-100 card-chart">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body px-2">--}}
{{--                    <div id="chart-6"></div>--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col -->--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="casrd card-sh-100">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body">--}}
{{--                    <!-- <div class="d-flex align-items-center py-3">--}}
{{--                        <div class="col-auto me-3">--}}
{{--                            <div class="icon">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--																		<polygon points="0 0 24 0 24 24 0 24"></polygon>--}}
{{--																		<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>--}}
{{--																		<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>--}}
{{--																	</g>--}}
{{--																</svg>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <h2><span class="counter-value" data-target="{{$number_of_user}}"></span></h2>--}}
{{--                            <h6 class="text-muted mb-0">عدد المسجلين</h6>--}}
{{--                        </div>--}}
{{--                    </div> -->--}}

{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col -->--}}

{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="casrd card-sh-100">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body">--}}
{{--                    <!-- <div class="d-flex align-items-center py-3">--}}
{{--                        <div class="col-auto me-3">--}}
{{--                            <div class="icon">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--        <polygon points="0 0 24 0 24 24 0 24"/>--}}
{{--        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>--}}
{{--        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>--}}
{{--    </g>--}}
{{--</svg>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <h2><span class="counter-value" data-target=""></span></h2>--}}
{{--                            <h6 class="text-muted mb-0">عدد المستخدمين تحت الإعتماد</h6>--}}
{{--                        </div>--}}
{{--                    </div> -->--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col-->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="casrd card-sh-100">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body">--}}
{{--                    <!-- <div class="d-flex align-items-center py-3">--}}
{{--                        <div class="col-auto me-3">--}}
{{--                            <div class="icon">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--        <polygon points="0 0 24 0 24 24 0 24"/>--}}
{{--        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>--}}
{{--        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>--}}
{{--    </g>--}}
{{--</svg>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <h2><span class="counter-value" data-target=""></span></h2>--}}
{{--                            <h6 class="text-muted mb-0">عدد المستخدمين المعتمدين</h6>--}}
{{--                        </div>--}}
{{--                    </div> -->--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col-->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="casrd card-sh-100">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body">--}}
{{--                    <!-- <div class="d-flex align-items-center py-3">--}}
{{--                        <div class="col-auto me-3">--}}
{{--                            <div class="icon">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--																		<polygon points="0 0 24 0 24 24 0 24"></polygon>--}}
{{--																		<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>--}}
{{--																		<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>--}}
{{--																	</g>--}}
{{--																</svg>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <h2><span class="counter-value" data-target=""></span></h2>--}}
{{--                            <h6 class="text-muted mb-0">عدد مراكز الخدمة</h6>--}}
{{--                        </div>--}}
{{--                    </div> -->--}}

{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col-->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="casrd card-sh-100">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body">--}}
{{--                    <!-- <div class="d-flex align-items-center py-3">--}}
{{--                        <div class="col-auto me-3">--}}
{{--                            <div class="icon">--}}
{{--                                <svg width="30" height="30" viewBox="0 0 512 512" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M484.582,319.536c-26.98-11.333-51.265-27.472-72.175-47.954c-12.721-12.472-34.628-12.472-47.391,0   c-6.171,6.046-12.721,11.588-19.462,16.863c-10.022-4.112-66.687-17.029-73.118-19.023c-12.745-3.964-23.117-13.665-28.077-25.858   c39.327-17.106,60.172-61.317,63.494-105.77v-6.657h16.715c5.038,0,9.114-4.082,9.114-9.114c0-5.032-4.076-9.114-9.114-9.114   h-11.392l-1.264-12.816c-2.985-30.166-23.692-55.217-52.755-63.833l-16.614-4.925v-6.218c0-5.032-4.076-9.114-9.114-9.114h-51.871   c-5.026,0-9.102,4.07-9.114,9.09l-0.012,6.183l-16.994,5.043c-28.944,8.58-49.634,33.524-52.719,63.524l-1.347,13.066H90.212   c-5.032,0-9.114,4.082-9.114,9.114c0,5.032,4.082,9.114,9.114,9.114h17.148l0.012,7.346c3.287,43.647,23.894,87.483,62.77,104.78   c-4.907,12.454-14.798,22.162-27.828,26.185c-11.072,3.418-54.054,12.828-54.054,12.828c-0.006,0-0.012,0-0.012,0   c-5.939,1.317-58.196,14.051-64.224,56.273c-3.637,25.395-7.88,49.497-7.886,49.545c-0.469,2.646,0.267,5.376,1.994,7.441   c1.733,2.065,4.29,3.252,6.984,3.252h279.23c10.336,20.672,22.791,40.265,37.411,58.54l20.951,26.179   c6.349,7.939,15.831,12.496,26.001,12.496c10.176,0,19.652-4.557,26.007-12.496l20.963-26.202   c27.466-34.343,47.521-73.196,59.602-115.478C497.873,332.756,493.269,323.179,484.582,319.536z M327.321,301.32   c-10.947,6.96-22.399,13.143-34.491,18.216c-3.459,1.46-6.028,4.017-7.992,6.948l8.111-33.032   C293.802,293.654,324.431,300.46,327.321,301.32z M253.977,53.727c21.924,6.503,37.541,25.407,39.796,48.168l1.092,11.013h-52.322   V50.339L253.977,53.727z M224.315,34.23v78.678h-33.833l0.172-78.678H224.315z M120.853,101.717   c2.326-22.642,17.937-41.451,39.772-47.931l11.766-3.489l-0.136,62.61h-52.553L120.853,101.717z M125.576,137.793v-6.657h164.061   l0.012,5.969c-3.584,47.658-30.344,95.731-82.048,95.731S129.136,184.762,125.576,137.793z M207.6,251.063   c6.847,0,13.267-0.777,19.397-2.029c3.323,8.817,8.503,16.602,15.107,22.969l-34.26,27.822l-34.812-28.119   c6.456-6.331,11.505-14.033,14.745-22.743C194.031,250.268,200.593,251.063,207.6,251.063z M121.891,293.458l22.168,87.098H86.308   v-78.868C89.56,300.685,113.744,295.339,121.891,293.458z M42.062,341.134c2.189-15.308,14.264-25.473,26.018-31.863v71.285H35.915   C37.505,371.003,39.902,356.24,42.062,341.134z M162.868,380.556l-23.271-91.429c2.99-0.783,14.863-4.794,18.044-6.408   l44.495,35.927c1.667,1.341,3.697,2.017,5.726,2.017c2.035,0,4.07-0.676,5.744-2.041l43.961-35.696   c3.032,1.507,14.65,5.394,17.676,6.183l-22.446,91.447H162.868z M271.564,380.556c0,0,10.277-39.772,10.579-38.722   c3.792,13.273,8.461,26.161,13.801,38.722H271.564z M421.444,445.907l-20.963,26.202c-5.75,7.191-17.789,7.191-23.544,0   l-20.945-26.179c-25.953-32.432-44.905-69.149-56.095-109.592c39.603-16.09,70.383-44.394,77.883-51.74   c2.943-2.884,6.824-4.474,10.941-4.474c4.106,0,7.986,1.59,10.924,4.474c22.571,22.096,48.767,39.505,78.103,52.227   C466.336,376.77,447.391,413.463,421.444,445.907z"></path><path d="M359.658,370.338c-3.56-3.56-9.327-3.56-12.888,0c-3.56,3.56-3.56,9.327,0,12.888l24.535,24.529   c2.035,2.053,4.753,3.18,7.642,3.18c2.89,0,5.601-1.127,7.619-3.157l50.286-50.292c3.56-3.56,3.56-9.327,0-12.888   c-3.554-3.56-9.327-3.56-12.888,0l-45.017,45.023L359.658,370.338z"></path></g></svg>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <h2><span class="counter-value" data-target=""></span></h2>--}}
{{--                            <h6 class="text-muted mb-0">عدد المقاولون</h6>--}}
{{--                        </div>--}}
{{--                    </div> -->--}}
{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col-->--}}
{{--        <div class="col-xl-4 col-md-6">--}}
{{--            <!-- card -->--}}
{{--            <div class="casrd card-sh-100">--}}
{{--                <!-- card body -->--}}
{{--                <div class="card-body">--}}
{{--                    <!-- <div class="d-flex align-items-center py-3">--}}
{{--                        <div class="col-auto me-3">--}}
{{--                            <div class="icon">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--        <path d="M20,8 L18.173913,8 C17.0693435,8 16.173913,8.8954305 16.173913,10 L16.173913,12 C16.173913,12.5522847 15.7261978,13 15.173913,13 L8.86956522,13 C8.31728047,13 7.86956522,12.5522847 7.86956522,12 L7.86956522,10 C7.86956522,8.8954305 6.97413472,8 5.86956522,8 L4,8 L4,6 C4,4.34314575 5.34314575,3 7,3 L17,3 C18.6568542,3 20,4.34314575 20,6 L20,8 Z" fill="#000000" opacity="0.3"/>--}}
{{--        <path d="M6.15999985,21.0604779 L8.15999985,17.5963763 C8.43614222,17.1180837 9.04773263,16.9542085 9.52602525,17.2303509 C10.0043179,17.5064933 10.168193,18.1180837 9.89205065,18.5963763 L7.89205065,22.0604779 C7.61590828,22.5387706 7.00431787,22.7026457 6.52602525,22.4265033 C6.04773263,22.150361 5.88385747,21.5387706 6.15999985,21.0604779 Z M17.8320512,21.0301278 C18.1081936,21.5084204 17.9443184,22.1200108 17.4660258,22.3961532 C16.9877332,22.6722956 16.3761428,22.5084204 16.1000004,22.0301278 L14.1000004,18.5660262 C13.823858,18.0877335 13.9877332,17.4761431 14.4660258,17.2000008 C14.9443184,16.9238584 15.5559088,17.0877335 15.8320512,17.5660262 L17.8320512,21.0301278 Z" fill="#000000" opacity="0.3"/>--}}
{{--        <path d="M20,10 L20,15 C20,16.6568542 18.6568542,18 17,18 L7,18 C5.34314575,18 4,16.6568542 4,15 L4,10 L5.86956522,10 L5.86956522,12 C5.86956522,13.6568542 7.21271097,15 8.86956522,15 L15.173913,15 C16.8307673,15 18.173913,13.6568542 18.173913,12 L18.173913,10 L20,10 Z" fill="#000000"/>--}}
{{--    </g>--}}
{{--</svg>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <h2><span class="counter-value" data-target=""></span></h2>--}}
{{--                            <h6 class="text-muted mb-0">عدد المكاتب الإستشارية</h6>--}}
{{--                        </div>--}}
{{--                    </div> -->--}}

{{--                </div><!-- end card body -->--}}
{{--            </div><!-- end card -->--}}
{{--        </div><!-- end col-->--}}


{{--    </div>--}}
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var barchart1 = {
        chart: {
            type: 'bar'
        },
        plotOptions: {
            bar: {
                distributed: true
            }
        } ,
        colors: ['#b78560', '#cd9b76', '#dfb08e', '#edc7ac', '#fbe0ce', '#f5e3d6', '#d9c7bb'],
        series: [{
            data: @json($bar)
        }]
    }
    new ApexCharts(document.querySelector("#barchart-1"), barchart1).render();

var chart1 = {
    chart: {
        type: 'area',
        height: 160,
        sparkline: {
            enabled: true
        },
    },

    stroke: {
        curve: 'straight'
    },
    fill: {
        opacity: 1,
    },
  series: [{
    name: 'المجوع',
    data: @json(array_values($box_with_files_in))
  }],
  labels: @json(array_keys($box_with_files_in)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text:'{{$count_box_with_files_in}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: ' المحاضر المسلمة لشركات حجاج الداخل',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-1"), chart1).render();

//




var chart2 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($box_with_files_out))
  }],
  labels: @json(array_keys($box_with_files_out)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: @json($count_box_with_files_out),
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'المحاضر المسلمة لشركات حجاج الخارج',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-2"), chart2).render();


//







var chart3 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($count_actions_performed_per_day))
  }],
  labels:  @json(array_keys($count_actions_performed_per_day)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: @json($count_actions_performed),
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'عدد الإجراءات المنفذة',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-3"), chart3).render();


//



var chart4 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($session_for_boxes))
  }],
  labels: @json(array_keys($session_for_boxes)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: '{{$session_count}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'المواعيد التي تم اطلاقها لإستلام المخيمات',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-4"), chart4).render();



//








var chart5 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($number_of_login_per_day))
  }],
  labels: @json(array_keys($number_of_login_per_day)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: '{{$number_of_login}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'مرات الدخول الى المنصة',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-5"), chart5).render();

var chart7 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($count_actions_outing_per_day))
  }],
  labels: @json(array_keys($count_actions_outing_per_day)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: '{{$count_actions_outing}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'عدد الطلبات الصادرة',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-7"), chart7).render();




//




var optionDonut = {
  chart: {
      type: 'donut',
      width: '100%',
      height: 250,
  },
    colors: ['#bf9370', '#8e6f50','#615036', '#745931','#663e00'],
    legend: {
      fontWeight: 400,
     formatter: function(seriesName, opts) {
        return '<div class="legend-info">' + '<span class="pe-2">' + seriesName + '</span>' + '<span class="text-dark font-size-18">' + opts.w.globals.series[opts.seriesIndex] + '</span>' + '</div>'
      }
    },
  series: @json(array_values($donat))
  ,
    dataLabels: {
      enabled: false,
    },
    labels: ['شركات الطوافة (حجاج الخارج) المسجلة', 'عدد شركات حجاج الداخل المسجلين', 'عدد المكاتب الهندسية المسجلة', 'عدد المقاولين المسجلين'],

     plotOptions: {
      pie: {
        donut: {
          labels: {
            show: true,
            name: {
              show: true,
              color: '#dfsda',
              offsetY: -10
            },
            value: {
              show: true,
              color: undefined,
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              label: 'المجموع',
              color: '#373d3f',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce((a, b) => {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
}

var donut = new ApexCharts(
  document.querySelector("#chart-6"),
  optionDonut
)
donut.render();

</script>
<div class="hs-dummy-scrollbar-size">
    <div style="height: 200%; width: 200%; margin: 10px 0;"></div>
</div><svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
           xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
           style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
    <defs id="SvgjsDefs1002"></defs>
    <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
    <path id="SvgjsPath1004" d="M0 0 "></path>
</svg><svg id="SvgjsSvg1418" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
           xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
           style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
    <defs id="SvgjsDefs1419"></defs>
    <polyline id="SvgjsPolyline1420" points="0,0"></polyline>
    <path id="SvgjsPath1421" d="M-1 69L-1 69L166.66666666666666 69L333.3333333333333 69L500 69C500 69 500 69 500 69 ">
    </path>
</svg>
@endsection
