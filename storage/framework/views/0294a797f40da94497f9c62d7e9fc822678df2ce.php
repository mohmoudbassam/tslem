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

    <!-- Bootstrap Css -->
    <link href="<?php echo e(url('/')); ?>/assets/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(url('/')); ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(url('/')); ?>/assets/css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url("/")); ?>/assets/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url("/")); ?>/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />

    <!-- alertifyjs default themes  Css -->
    <link href="<?php echo e(url("/")); ?>/assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <?php echo $__env->yieldContent('style'); ?>
    <style>
        @font-face {
            font-family: JannaLT;
            src: url('<?php echo e(url('/assets/fonts/JannaLT-Regular.woff')); ?>');
        }

        body {
            font-family: JannaLT !important;
        }

         [dir=rtl] input {
             text-align: right;
         }
         .modal {
             display:    none;
             position:   fixed;
             z-index:    1000;
             top:        0;
             left:       0;
             height:     100%;
             width:      100%;
             background: rgba( 255, 255, 255, .8 )
             url('http://i.stack.imgur.com/FhHRx.gif')
             50% 50%
             no-repeat;
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


    </style>
</head>

<body lang="en" dir="rtl">
<?php /**PATH /Users/ahmedsal/workspace/tslem/resources/views/CP/layout/head.blade.php ENDPATH**/ ?>