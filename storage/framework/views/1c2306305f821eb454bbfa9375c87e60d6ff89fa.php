<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>تسجيل الدخول</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(url('/')); ?>/logo.png">

    <!-- preloader css -->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?php echo e(url('/')); ?>/assets/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(url('/')); ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(url('/')); ?>/assets/css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/')); ?>/assets/css/login.css" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        :root {
            --main-color: #122b76;
            --second-color: #c0946f;
        }
        .bg-second {
            --bs-bg-opacity: 1;
            background-color: rgba(192, 148, 111, var(--bs-bg-opacity)) !important;
        }

        .btn-second {
            background-color: var(--second-color) !important;
            color: white !important;
            border-color: var(--second-color) !important;
            border-radius: 0.9rem !important;
        }

        .login-page-form-container {
            position: absolute;
            width: 30%;
            height: 80%;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            background: white;
            text-align: center;
        }

        @media (max-width: 1300px) {
            .login-page-form-container {
                width: 50%;
            }
        }
        @media (max-width: 950px) {
            .login-page-form-container {
                width: 80%;
            }
        }

        @media (max-width: 780px) {
            .auth-bg {
                display: none !important;
            }
        }


    </style>
</head>

<body  lang="en" dir="rtl">

<!-- <body data-layout="horizontal"> -->
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
        
            <!-- end col -->
            <div class="col-24" style="position: relative;">
                <div class="row login-page-form-container">

                <div class="col-12">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="<?php echo e(url('/')); ?>" class="d-block auth-logo">
                                    <img src="<?php echo e(url('/')); ?>/assets/img/tsleem-logo.png" alt=""  width="150px"> <span class="logo-txt"></span>
                                </a>
                            </div>

                            <?php if(session('success')): ?>
                                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                            <?php endif; ?>
                            <div class="auth-content my-auto">

                                <div class="text-center">
                                    <h2>تسجيل الدخول</h2>
                                </div>
                                <form class="mt-4 pt-2" action="<?php echo e(route('login')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3">
                                        <label class="form-label">إسم المستخدم</label>
                                        <input type="text" class="form-control" id="username" autocomplete="off" name="user_name" placeholder="اسم المستخدم">
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label">كلمة المرور</label>
                                            </div>





                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password"  name="password"  class="form-control" placeholder="كلمة المرور" aria-label="Password" autocomplete="off" aria-describedby="password-addon">
                                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" checked="true" type="checkbox" id="remember-check">
                                                <label class="form-check-label" for="remember-check">
                                                    تذكرني
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <?php if(session('validationErr')): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo e(session('validationErr')); ?>

                                    </div>
                                    <?php endif; ?>
                                    <div class="mb-3">
                                        <button class="btn btn-lg btn-secondary w-100 waves-effect waves-light" type="submit">دخول</button>
                                    </div>
                                </form>







                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <?php echo e(\Alkoumi\LaravelHijriDate\Hijri::Date('Y')); ?> منصة تسليم </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>

            </div>
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-second"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-7">
                            <div class="p-0 p-sm-4 px-xl-0">
                                <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <!-- end carouselIndicators -->

                                    <!-- end carousel-inner -->
                                </div>
                                <!-- end review carousel -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>


<!-- JAVASCRIPT -->
<script src="<?php echo e(url('/')); ?>/assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="<?php echo e(url('/')); ?>/assets/libs/pace-js/pace.min.js"></script>
<!-- password addon init -->
<script src="<?php echo e(url('/')); ?>/assets/js/pages/pass-addon.init.js"></script>

</body>

</html>
<?php /**PATH C:\wamp64\www\taslem\resources\views/CP/login.blade.php ENDPATH**/ ?>