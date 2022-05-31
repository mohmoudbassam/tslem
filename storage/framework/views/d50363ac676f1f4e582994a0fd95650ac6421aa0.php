<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>تسجيل الدخول</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(url('/')); ?>/logo.png" />

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

            .alert-danger {
                color: #e9ecef;
                background-color: #db1c19;
                border-color: #e21a13;
                font-size: 16px;
                font-family: Janna !important;
            }
            .alert-success {
                font-size: 16px;
                font-family: Janna !important;
                color: #e9ecef;
                background-color: #126a47;
                border-color: #126a47;
            }
            /*  */
            .login{
                background-color: #FFF;
            }
            .login .form-label{
                color: #0A2373;
            }
            .login .form-control{
                text-align: start;
            }
            .login-body{
                background-color: var(--second-color) !important;
                padding: 30px;
            }
            .bg{
                position: relative;
                z-index: 1;
                display: inline-block;
                padding: 0px 30px;
            }

            .bg::before {
                position: absolute;
                content: "";
                z-index: -1;
                background-image: url("<?php echo e(url('/')); ?>/assets/img/bg.png");
                background-size: auto;
                background-repeat: no-repeat;
                width: 60px;
                height: 62px;
                right: 0;
                top: 50%;
                transform: translateY(-50%);
                background-position: 11px center;

            }
            .btn-blue {
                background-color: #0A2373;
                border-color: #0A2373;
                color: #FFF !important;
            }
            .bg-page-login{
                min-height: 100vh;
                background-image: url("<?php echo e(url('/')); ?>/assets/img/bg-login.png");
                background-size: cover;
                background-repeat: no-repeat;
            }
            @media(min-width:992px){
                .bg-page-login{
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            }
            .bg-body{
                background-image: url("<?php echo e(url('/')); ?>/assets/img/bg-login-body.png");
                background-size: auto;
                background-repeat: no-repeat;
                background-position: bottom right;
            }
        </style>
    </head>

    <body lang="en" dir="rtl">
        <!-- <body data-layout="horizontal"> -->
        <div class="auth-page bg-page-login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-8 col-lg-5 col-xl-4 col-xxl-3 mx-auto">
                        <form class="mt-4 pt-2" action="<?php echo e(route('login')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="login">
                                <div class="login-header p-4">
                                    <div class="mb-0">
                                        <a href="<?php echo e(url('/')); ?>" class="d-block auth-logo">
                                            <img src="<?php echo e(url('/')); ?>/assets/img/logo2.png" alt=""  width="100px"> <span class="logo-txt"></span>
                                        </a>
                                    </div>
                                    <div class="text-center mb-1">
                                        <h2 class="bg mb-0">تسجيل الدخول</h2>
                                    </div>
                                </div>
                                <?php if(session('success')): ?>
                                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                                <?php endif; ?>
                                <div class="login-body bg-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label">إسم المستخدم</label>
                                        <input type="text" class="form-control border-0" id="username" autocomplete="off" name="user_name" placeholder="اسم المستخدم">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">كلمة المرور</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password"  name="password"  class="form-control border-0" placeholder="كلمة المرور" aria-label="Password" autocomplete="off" aria-describedby="password-addon">
                                            <button class="btn btn-light shadow-none ms-0 bg-white border-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" checked="true" type="checkbox" id="remember-check">
                                            <label class="form-check-label text-white " for="remember-check">
                                            تذكرني
                                            </label>
                                        </div>
                                    </div>
                                    <?php if(session('validationErr')): ?>
                                    <div class="mb-2">
                                        <div class="alert alert-danger p-2" role="alert">
                                            <?php echo e(session('validationErr')); ?>

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="mb-0 text-end">
                                        <button class="btn px-5 py-1 btn-blue waves-effect waves-light" type="submit">دخول</button>
                                    </div>
                                </div>
                                <div class="login-footer py-3 px-4">
                                    <div class="text-end mb-3">
                                        <a href="" class="btn px-2 py-1 btn-secondary shadow-none">مستخدم جديد</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
<?php /**PATH /Users/ahmedsal/workspace/tslem/resources/views/CP/login.blade.php ENDPATH**/ ?>