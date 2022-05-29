@include('CP.layout.head')

<!-- <body data-layout="horizontal"> -->

<!-- Begin page -->
<div id="layout-wrapper">


@include('CP.layout.top_bar')

<!-- ========== Left Sidebar Start ========== -->
@include('CP.layout.menu')
<!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                @if(\Request::route()->getName()=='dashboard')

                <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">الإحصائيات</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">الرئيسية</a></li>
                                            <li class="breadcrumb-item active">الإحصائيات</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xl-2 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center text-center">
                                            <div class="col-12">
                                                <br>
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">عدد المسجلين</span>
                                                <h4 class="mb-3">
                                                   <span class="counter-value" data-target="{{$all_user}}">{{$all_user}}</span>
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
                                        <div class="row align-items-center text-center">
                                            <div class="col-12">
                                                <br>
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">عدد المستخدمين الغير معتمدين</span>
                                                <h4 class="mb-3">
                                                   <span class="counter-value" data-target="{{$not_verified}}">{{$not_verified}}</span>
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
                                        <div class="row align-items-center text-center">
                                            <div class="col-12">
                                                <br>
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">عدد المستخدمين المعتمدين</span>
                                                <h4 class="mb-3">
                                                   <span class="counter-value" data-target="{{$verified}}">{{$verified}}</span>
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
                                        <div class="row align-items-center text-center">
                                            <div class="col-12">
                                                <br>
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">عدد مراكز الخدمة</span>
                                                <h4 class="mb-3">
                                                   <span class="counter-value" data-target="{{$service_providers}}">{{$service_providers}}</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            


                            <div class="col-xl-2 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center text-center">
                                            <div class="col-12">
                                                <br>
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">عدد المقاولين </span>
                                                <h4 class="mb-3">
                                                   <span class="counter-value" data-target="{{$contractors}}">{{$contractors}}</span>
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
                                        <div class="row align-items-center text-center">
                                            <div class="col-12">
                                                <br>
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">عدد المكاتب </span>
                                                <h4 class="mb-3">
                                                   <span class="counter-value" data-target="{{$design_offices}}">{{$design_offices}}</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
        
                          


                         


                        </div><!-- end row-->

                    @endif
                @yield('content')
                <div class="col-12">

                    @if(auth()->user()->verified == 2 && !auth()->user()->isAdmin() )
                    <div class="alert alert-danger">

                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">




                            تم رفض حسابك للأسباب التاليه:     {{auth()->user()->reject_reason}}

                            <div class="page-title-right">
                                <ol class="breadcrumb ">
                                    <li class="breadcrumb-item"><a href="{{route('edit_profile')}}">تعديل الملف الشخصي</a></li>

                                </ol>
                            </div>

                        </div>

                    </div>
                    @endif
                </div>

            </div>

        </div>

            @include('CP.layout.footer')
    </div>


</div>


<div class="rightbar-overlay"></div>

<script src="{{url('/')}}/assets/libs/jquery/jquery.min.js"></script>
<script src="{{url('/')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="{{url('/')}}/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{url('/')}}/assets/libs/node-waves/waves.min.js"></script>
<script src="{{url('/')}}/assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="{{url('/')}}/assets/libs/pace-js/pace.min.js"></script>

<!-- apexcharts -->
<script src="{{url('/')}}/assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Plugins js-->
<script src="{{url('/')}}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{url('/')}}/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
<!-- dashboard init -->
<script src="{{url('/')}}/assets/js/pages/dashboard.init.js"></script>

<script src="{{url('/')}}/assets/js/app.js"></script>
<script src="{{url("/")}}/assets/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{url("/")}}/assets/jquery-validation/dist/localization/messages_ar.min.js" type="text/javascript"></script>
<script scr="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script src="{{url("/")}}/assets/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/bootstrap-fileinput/fileinput-theme.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/datatables/datatables.bundle.js?v=7.0.4"></script>
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<script src="{{url("/")}}/assets/scripts.bundle.js"></script>
<script src="{{url("/")}}/assets/libs/alertifyjs/build/alertify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="{{url("/")}}/assets/libs/@simonwep/pickr/pickr.min.js"></script>
<script src="{{url("/")}}/assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

<!-- datepicker js -->
<script src="assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src = "{{url('/assets/libs/flatpickr/flatpickr.min.js')}}" type="text/javascript"></script>

@include('CP.layout.js')
@yield('scripts')
    <script>
        function read_message(){

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
    </script>

@php(session()->forget('success'))
</body>

</html>
