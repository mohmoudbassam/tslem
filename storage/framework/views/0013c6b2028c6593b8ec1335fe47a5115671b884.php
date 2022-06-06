<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- App favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <!-- plugin css -->
    <link href="<?php echo e(url('/')); ?>/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/css/preloader.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/css/custom-panel.css?v=<?php echo e(config('app.asset_ver')); ?>" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?php echo e(url('/')); ?>/assets/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(url('/')); ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(url('/')); ?>/assets/css/app-rtl-2.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url("/")); ?>/assets/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url("/")); ?>/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />

    <!-- alertifyjs default themes  Css -->
    <link href="<?php echo e(url("/")); ?>/assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo e(url("/")); ?>/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="<?php echo e(url('/assets/libs/flatpickr/flatpickr.min.css')); ?>"/>
        <style>
            .required-field:after {
                position: relative;
                top: 3px;
                right: 6px;
                content: "*";
                color: #fd625e;
            }
            .modal-backdrop.show {
                display: initial !important;
            }
            .modal-backdrop.fade {
                display: initial !important;
            }
        @font-face {
            font-family: JannaLT;
            src: url('<?php echo e(url('/assets/fonts/JannaLT-Regular.woff')); ?>');
        }

        /* body {
            font-family: JannaLT !important;
        } */
        .container {
            position: fixed;
            right: 0;
            top: 0;
        }
         [dir=rtl] input {
             text-align: right;
         }


         /* When the body has the loading class, we turn
            the scrollbar off with overflow:hidden */
         body.loading .modal {
             overflow: hidden;
         }

         /* Anytime the body has the loading class, our
            modal element will be visible */
         body.loading .modal {
             display: block;
         }

        .modal-header {
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
        }

        .modal-header h5 {
            color: white !important;
        }

        .modal-content {
            -webkit-box-shadow: 0 2px 8px 0 rgb(81 86 190 / 30%);
            box-shadow: 0 2px 8px 0 rgb(81 86 190 / 30%);
        }

        .alert-danger{
            color: #e9ecef;
            background-color: #db1c19;
            border-color: #e21a13;
            font-size: 16px;
            /* font-family: JannaLT !important; */
        }
        .alert-success{
            font-size: 16px;
            /* font-family: JannaLT !important; */
            color: #e9ecef;
            background-color: #126a47;
            border-color: #126a47;

        }

    </style>

    <?php echo $__env->yieldContent('style'); ?>
</head>

<body lang="en" dir="rtl">
<?php /**PATH C:\wamp64\www\taslem\resources\views/CP/layout/head.blade.php ENDPATH**/ ?>