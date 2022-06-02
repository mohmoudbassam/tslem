<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>بوابة تسليم الرقمية مركز ريادي متكامل</title>
    <meta property="og:type" content=""/>
    <meta property="og:title" content=""/>
    <meta property="og:description" content=" "/>
    <meta property="og:image" content=""/>
    <meta property="og:image:width" content=""/>
    <meta property="og:image:height" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=" "/>
    <meta property="og:ttl" content=""/>
    <meta name="twitter:card" content=""/>
    <meta name="twitter:domain" content=""/>
    <meta name="twitter:site" content=""/>
    <meta name="twitter:creator" content=""/>
    <meta name="twitter:image:src" content=""/>
    <meta name="twitter:description" content=""/>
    <meta name="twitter:title" content=" "/>
    <meta name="twitter:url" content=""/>
    <meta name="description" content="  "/>
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <meta name="copyright" content=" "/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugin.min.css?v='.config('app.asset_ver'))); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css?v='.config('app.asset_ver'))); ?>"/>
</head>
<body>
<!-- start:: Page -->
<div class="main-wrapper">
    <div class="loader-page"><span></span><span></span></div>
    <!-- start:: Header -->
    <header class="main-header">
        <div class="container">
            <div class="d-flex align-items-center header-top">
                <div class="logo">
                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('assets/images/logo-dark.png')); ?>" alt=""/></a>
                </div>
                <div class="menu--mobile mx-lg-auto">
                    <div
                        class="menu-container d-flex align-items-center justify-content-between d-lg-none px-3 border-bottom py-2 mb-3">
                        <div class="logo">
                            <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('assets/images/logo-dark.png')); ?>" alt=""/></a>
                        </div>
                        <div class="btn-close-header-mobile justify-content-end"><i class="fa-light fa-xmark"></i></div>
                    </div>
                    <div class="menu-container mx-auto menu-nav">
                        <ul class="main-menu">
                            <li class="menu_item"><a class="menu_link active" data-scroll="section-home">الرئيسية</a>
                            </li>
                            <li class="menu_item"><a class="menu_link" data-scroll="section-about">عن المركز</a></li>
                            <li class="menu_item"><a class="menu_link" data-scroll="section-guidelines">الدلائل واللوائح</a></li>
                            <li class="menu_item"><a class="menu_link">تأهيل مزودي الخدمات</a>
                                <ul class="main-menu-sub">
                                    <li><a>شركات ومكاتب</a></li>
                                    <li><a>مقاولين</a></li>
                                </ul>
                            </li>
                            <li class="menu_item"><a class="menu_link" data-scroll="">المركز الاعلامي</a></li>
                            <li class="menu_item"><a class="menu_link">الخدمات الألكترونية</a>
                                <ul class="main-menu-sub">
                                    <li><a>تسليم مخيمات</a></li>
                                    <li><a>استلام مخيمات</a></li>
                                    <li><a>اضافات خاصة</a></li>
                                    <li><a>متابعة طلب</a></li>
                                    <li><a>النماذج</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="menu-container ms-lg-auto menu-nav my-2 my-lg-0 px-4 px-lg-0">
                        <ul class="main-menu d-flex align-items-center">
                            <li class="menu_item"><a class="btn btn-primary bg" href="<?php echo e(route('login_page')); ?>">تسجيل
                                    الدخول</a></li>
                            <li class="menu_item me-2 me-lg-0"><a class="btn btn-outline-white me-lg-2"
                                                                  href="<?php echo e(route('register')); ?>">تسجيل</a></li>
                        </ul>
                    </div>
                    <div class="menu-container col-auto px-4 px-lg-0">
                        <ul class="main-menu d-flex align-items-lg-center social-media">
                            <li>
                                <a href=""> <i class="fa-brands fa-youtube"></i></a>
                            </li>
                            <li>
                                <a href=""> <i class="fa-brands fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href=""> <i class="fa-brands fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href=""> <i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="header-mobile__toolbar me-auto d-lg-none fa-lg"><i class="fa-light fa-bars"></i></div>
            </div>
            <div class="ticker-wrapper-h " style="background:#cbb0a2 ; color:#c3b0b0">
                <div class="heading " style="background-color: #0b5ed7 " >الشريط الاخباري </div>
                <ul class="news-ticker-h">
                    <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="color: white !important"><a href=""><?php echo e($_news->news); ?></a></li>
                        <li style="color: white !important"><a href="">||</a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
         </div>


    </header>


    <section class="section section-home" id="section-home">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-lg-4 col-xl-3 mb-4 mx-auto">
                    <div class="home-content">
                        <h2 class="wow fadeInUp font-bold text-white mb-lg-3" data-wow-delay="0.2s">البوابة الرقمية</h2>
                        <h3 class="wow fadeInUp font-bold" data-wow-delay="0.3s" style="color: #C0946F">تسليم</h3>
                        <h3 class="wow fadeInUp font-bold text-white" data-wow-delay="0.4s">مركز ريــادي متكامل</h3>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <!-- end:: section -->
    <!-- start:: section -->
    <section class="section section-about pt-5" id="section-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="section-title mb-3">
                                <h2 class="font-bold bg bg-start">عن المركز</h2>
                            </div>
                            <div class="section-about-desc">مركز ريادي ومتكامل لتقديم الخدمات اللازمة لمقدمـي خدمات الحج؛ بغرض تسهيـل
                                الاجـراءات من خلال العمل تحت مظلة واحدة لكافة الجهات، سيحقق هذا المركز الارتقاء</div>
                            <div class="widget__item-serve-list row">
                                <div class="col-6 widget__item-serve">
                                خدمة مميزة
                                </div>
                                <div class="col-6 widget__item-serve">
                                بيانات آمنة
                                </div>
                                <div class="col-6 widget__item-serve">
                                متابعة مستمرة
                                </div>
                                <div class="col-6 widget__item-serve">
                                سهولة الخدمات
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->
    <!-- start:: section -->
    <section class="section section-guidelines" id="section-guidelines">
        <div class="container">
            <div class="position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-6">
                        <div class="swiper-slide">
                            <a href="<?php echo e(url('/').'/guide/mina'); ?>" target="_blank"
                               class="widget__item-downlaod text-center">
                                <h4 class="widget__item-title">ادلة مشعر منى</h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="swiper-slide">
                            <a href="<?php echo e(url('/').'/guide/arafat'); ?>"
                               target="_blank" class="widget__item-downlaod text-center">
                                <h4 class="widget__item-title">ادلة مشعر عرفات</h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="swiper-slide">
                            <div
                               class="widget__item-downlaod text-center">
                               <img src="<?php echo e(asset('assets/images/mina-qr.png')); ?>" alt="">
                                <h4 class="widget__item-title qr">QR موقع مشعر منى</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="swiper-slide">
                            <div
                               class="widget__item-downlaod text-center">
                                <img src="<?php echo e(asset('assets/images/2.png')); ?>" alt="">
                                <h4 class="widget__item-title qr">QR موقع مشعر عرفات</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->
    <!-- start:: footer -->
    <footer class="main-footer">
        <div class="footer-top">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row justify-content-between">
                            <div class="col-lg-3 mb-4 mb-lg-0">
                                <div class="logo mb-lg-4 mb-2"><img src="<?php echo e(asset('assets/images/logo-dark.png')); ?>" alt=""/></div>
                                <ul class="social-media">
                                    <li>
                                        <a href=""> <i class="fa-brands fa-youtube"></i></a>
                                    </li>
                                    <li>
                                        <a href=""> <i class="fa-brands fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href=""> <i class="fa-brands fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href=""> <i class="fa-brands fa-facebook-f"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-3">
                                <div class="footer-top-links">
                                    <div class="footer-top-title">مواقع صديقة</div>
                                    <ul class="links">
                                        <li><a href="https://kidana.com.sa" target="_blank">مواقع شركة كدانة</a></li>
                                        <li><a href="https://www.haj.gov.sa"  target="_blank">موقع وزارة الحج</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="footer-top-links">
                                    <div class="footer-top-title">روابط سريعة</div>
                                    <ul class="links">
                                        <li><a href="#">الخدمات الإلكترونية</a></li>
                                        <li><a href="#">تاهيل مزودي الخدمة</a></li>
                                        <li><a href="#">الدلائل والنماذج</a></li>
                                        <li><a href="<?php echo e(route('login_page')); ?>">تسجيل الدخول</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="footer-top-links">
                                    <div class="footer-top-title">التواصل</div>
                                    <ul class="links">
                                        <li>
                                            <a href="https://wa.me/+966599720750" target="_blank">
                                                <i class="fa-brands fa-whatsapp text-success mx-1"></i>
                                                <span>
                                                    العملاء: 0599720750
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://wa.me/+966583392323" target="_blank">
                                                <i class="fa-brands fa-whatsapp text-success mx-1"></i>
                                                <span>
                                                    الدعم التقني : 0583392323
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row align-items-center">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <p class="text-center text-lg-end text">جميع الحقوق محفوظة لدى البوابة الرقمية تسليم
                                    © <?php echo e(\Alkoumi\LaravelHijriDate\Hijri::Date('Y')); ?></p>
                            </div>
                            <div class="col-lg-6">
                                <a href="https://kidana.com.sa" target="_blank"
                                    class="d-flex align-items-center justify-content-center justify-content-lg-end image-brand">
                                    <img src="<?php echo e(asset('assets/images/footer-kidana-logo.png')); ?>" alt=""/></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end:: footer -->
</div>
<!-- end:: Page -->
<script src="<?php echo e(asset('assets/js/script.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/function.js')); ?>"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="jquery.simpleTicker.css" rel="stylesheet">
<script type="text/javascript">

        $(function () {
            $('#js-news').ticker();
        });
</script>

</body>
</html>
<?php /**PATH C:\wamp64\www\taslem\resources\views/public.blade.php ENDPATH**/ ?>