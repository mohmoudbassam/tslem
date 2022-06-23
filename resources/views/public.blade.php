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
    <link rel="stylesheet" href="{{ asset('assets/css/plugin.min.css?v='.config('app.asset_ver')) }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v='.config('app.asset_ver')) }}"/>
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
                    <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo-dark.png') }}" alt=""/></a>
                </div>
                <div class="menu--mobile mx-lg-auto">
                    <div
                        class="menu-container d-flex align-items-center justify-content-between d-lg-none px-3 border-bottom py-2 mb-3">
                        <div class="logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo-dark.png') }}" alt=""/></a>
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
                            <li class="menu_item"><a class="menu_link">المركز الاعلامي</a>
                                <ul class="main-menu-sub">
                                    <li><a href="{{ route('NewsArticles.Mainlist') }}">الأخبار</a></li>
                                        <li><a href="{{ route('Photoes.Photoes') }}">الصور</a></li>
<li><a href="{{ route('Videos.Videos') }}">الفيديوهات</a></li>
                                </ul>
                            </li>
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
                            <li class="menu_item"><a class="btn btn-primary bg" href="{{ route('login_page') }}">تسجيل
                                    الدخول</a></li>
                            <li class="menu_item me-2 me-lg-0"><a class="btn btn-outline-white me-lg-2"
                                                                  href="{{ route('register') }}">تسجيل</a></li>
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
                    @foreach($news as $_news)
                        <li style="color: white !important"><a href="">{{$_news->news}}</a></li>
                        <li style="color: white !important"><a href="">||</a></li>
                    @endforeach
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
                        <h3 class="wow fadeInUp font-bold" data-wow-delay="0.3s" style="color: #0A2373">تسليم</h3>
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
                            <a href="{{url('/').'/guide/mina'}}" target="_blank"
                               class="widget__item-downlaod text-center">
                                <h4 class="widget__item-title">ادلة مشعر منى</h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="swiper-slide">
                            <a href="{{url('/').'/guide/arafat'}}"
                               target="_blank" class="widget__item-downlaod text-center">
                                <h4 class="widget__item-title">ادلة مشعر عرفات</h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="swiper-slide">
                            <div
                               class="widget__item-downlaod text-center">
                               <img src="{{ asset('assets/images/mina-qr.png') }}" alt="">
                                <h4 class="widget__item-title qr">QR موقع مشعر منى</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="swiper-slide">
                            <div
                               class="widget__item-downlaod text-center">
                                <img src="{{ asset('assets/images/2.png') }}" alt="">
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
                                <div class="logo mb-lg-4 mb-2"><img src="{{ asset('assets/images/logo-dark.png') }}" alt=""/></div>
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
                                        <li><a href="{{ route('login_page') }}">تسجيل الدخول</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="footer-top-links">
                                    <div class="footer-top-title">تواصل معنا</div>
                                    <ul class="links">
                                        <li class="mb-2"><a href="https://wa.me/+966599720750" target="_blank" class="d-flex align-items-center">
                                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                            <svg version="1.1" width="30" class="ps-2" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 58 58" style="enable-background: new 0 0 58 58;" xml:space="preserve">
                                            <g>
                                            <path
                                            style="fill: #2cb742;"
                                            d="M0,58l4.988-14.963C2.457,38.78,1,33.812,1,28.5C1,12.76,13.76,0,29.5,0S58,12.76,58,28.5
                                                    S45.24,57,29.5,57c-4.789,0-9.299-1.187-13.26-3.273L0,58z"
                                            />
                                            <path
                                            style="fill: #ffffff;"
                                            d="M47.683,37.985c-1.316-2.487-6.169-5.331-6.169-5.331c-1.098-0.626-2.423-0.696-3.049,0.42
                                                    c0,0-1.577,1.891-1.978,2.163c-1.832,1.241-3.529,1.193-5.242-0.52l-3.981-3.981l-3.981-3.981c-1.713-1.713-1.761-3.41-0.52-5.242
                                                    c0.272-0.401,2.163-1.978,2.163-1.978c1.116-0.627,1.046-1.951,0.42-3.049c0,0-2.844-4.853-5.331-6.169
                                                    c-1.058-0.56-2.357-0.364-3.203,0.482l-1.758,1.758c-5.577,5.577-2.831,11.873,2.746,17.45l5.097,5.097l5.097,5.097
                                                    c5.577,5.577,11.873,8.323,17.45,2.746l1.758-1.758C48.048,40.341,48.243,39.042,47.683,37.985z"
                                            />
                                            </g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            </svg>
                                             العملاء : 0599720750
                                            </a></li>
                                            <li><a href="https://wa.me/+966583392323" target="_blank" class="d-flex align-items-center">
                                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                            <svg version="1.1" width="30" class="ps-2" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 58 58" style="enable-background: new 0 0 58 58;" xml:space="preserve">
                                            <g>
                                            <path
                                            style="fill: #2cb742;"
                                            d="M0,58l4.988-14.963C2.457,38.78,1,33.812,1,28.5C1,12.76,13.76,0,29.5,0S58,12.76,58,28.5
                                                    S45.24,57,29.5,57c-4.789,0-9.299-1.187-13.26-3.273L0,58z"
                                            />
                                            <path
                                            style="fill: #ffffff;"
                                            d="M47.683,37.985c-1.316-2.487-6.169-5.331-6.169-5.331c-1.098-0.626-2.423-0.696-3.049,0.42
                                                    c0,0-1.577,1.891-1.978,2.163c-1.832,1.241-3.529,1.193-5.242-0.52l-3.981-3.981l-3.981-3.981c-1.713-1.713-1.761-3.41-0.52-5.242
                                                    c0.272-0.401,2.163-1.978,2.163-1.978c1.116-0.627,1.046-1.951,0.42-3.049c0,0-2.844-4.853-5.331-6.169
                                                    c-1.058-0.56-2.357-0.364-3.203,0.482l-1.758,1.758c-5.577,5.577-2.831,11.873,2.746,17.45l5.097,5.097l5.097,5.097
                                                    c5.577,5.577,11.873,8.323,17.45,2.746l1.758-1.758C48.048,40.341,48.243,39.042,47.683,37.985z"
                                            />
                                            </g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            </svg>
                                            الدعم الفني  : 0583392323
                                            </a></li>
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
                                    © {{ \Alkoumi\LaravelHijriDate\Hijri::Date('Y') }}</p>
                            </div>
                            <div class="col-lg-6">
                                <a href="https://kidana.com.sa" target="_blank"
                                    class="d-flex align-items-center justify-content-center justify-content-lg-end image-brand">
                                    <img src="{{ asset('assets/images/footer-kidana-logo.png') }}" alt=""/></a>
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
<script src="{{ asset('assets/js/script.min.js') }}"></script>
<script src="{{ asset('assets/js/function.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="jquery.simpleTicker.css" rel="stylesheet">
<script type="text/javascript">

        $(function () {
            $('#js-news').ticker();
        });
</script>

</body>
</html>
