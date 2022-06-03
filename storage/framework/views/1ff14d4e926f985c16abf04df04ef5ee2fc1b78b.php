<?php echo $__env->make('CP.layout.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- <body data-layout="horizontal"> -->

<!-- Begin page -->
<div id="layout-wrapper">


<?php echo $__env->make('CP.layout.top_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- ========== Left Sidebar Start ========== -->
<?php echo $__env->make('CP.layout.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

            <?php if(auth()->user()->verified == 0 &&  !auth()->user()->isAdmin() ): ?> <div class="alert alert-danger p-2 font-14"> لم يتم اعتماد حسابك بعد </div> <?php endif; ?>


                <?php echo $__env->yieldContent('content'); ?>

                    <?php if(auth()->user()->verified == 2 && !auth()->user()->isAdmin() ): ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger">
                                    تم رفض تأكيد الحساب
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-row justify-content-between">
                                        <h1 class="card-title">
                                            ملاحظات رفض تأكيد الحساب
                                        </h1>
                                        <a href="<?php echo e(route('edit_profile')); ?>">
                                            <i class="fa fa-edit"></i>
                                            تعديل الملف الشخصي
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="m-0">
                                                    <?php $__currentLoopData = explode("\r\n", auth()->user()->reject_reason); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <?php echo e($reason); ?>

                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


            </div>

        </div>

            <?php echo $__env->make('CP.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>


</div>


<div class="rightbar-overlay"></div>

<script src="<?php echo e(url('/')); ?>/assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="<?php echo e(url('/')); ?>/assets/libs/pace-js/pace.min.js"></script>

<!-- apexcharts -->
<script src="<?php echo e(url('/')); ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Plugins js-->
<script src="<?php echo e(url('/')); ?>/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
<!-- dashboard init -->
<script src="<?php echo e(url('/')); ?>/assets/js/pages/dashboard.init.js"></script>

<script src="<?php echo e(url('/')); ?>/assets/js/app.js"></script>
<script src="<?php echo e(url("/")); ?>/assets/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo e(url("/")); ?>/assets/jquery-validation/dist/localization/messages_ar.min.js" type="text/javascript"></script>
<script scr="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script src="<?php echo e(url("/")); ?>/assets/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
<script src="<?php echo e(url("/")); ?>/assets/bootstrap-fileinput/fileinput-theme.js" type="text/javascript"></script>
<script src="<?php echo e(url("/")); ?>/assets/datatables/datatables.bundle.js?v=7.0.4"></script>
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<script src="<?php echo e(url("/")); ?>/assets/scripts.bundle.js"></script>
<script src="<?php echo e(url("/")); ?>/assets/libs/alertifyjs/build/alertify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="<?php echo e(url("/")); ?>/assets/libs/@simonwep/pickr/pickr.min.js"></script>
<script src="<?php echo e(url("/")); ?>/assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

<!-- datepicker js -->
<script src="<?php echo e(asset('assets/libs/flatpickr/flatpickr.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src = "<?php echo e(url('/assets/libs/flatpickr/flatpickr.min.js')); ?>" type="text/javascript"></script>
<script src="https://unpkg.com/feather-icons"></script>


<?php echo $__env->make('CP.layout.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('scripts'); ?>
    <script>
        $(function () {
            feather.replace();
        });
        function read_message(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : '<?php echo e(route('read_message')); ?>',
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

<?php (session()->forget('success')); ?>
</body>

</html>
<?php /**PATH C:\wamp64\www\taslem\resources\views/CP/master.blade.php ENDPATH**/ ?>