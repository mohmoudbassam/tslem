<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>بوابة تسليم الرقمية مركز ريادي متكامل</title>
    <meta property="og:type" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content=" " />
    <meta property="og:image" content="" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content=" " />
    <meta property="og:ttl" content="" />
    <meta name="twitter:card" content="" />
    <meta name="twitter:domain" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:creator" content="" />
    <meta name="twitter:image:src" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:title" content=" " />
    <meta name="twitter:url" content="" />
    <meta name="description" content="  " />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="copyright" content=" " />
    <link rel="stylesheet" href="{{ asset('assets/css/plugin.min.css?v='.config('app.asset_ver')) }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v='.config('app.asset_ver')) }}" />

    <style>
        .row>.column {
            padding: 0 8px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Create four equal columns that floats next to eachother */
        .column {
            float: left;
            width: 25%;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: black;
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            width: 90%;
            max-width: 1200px;
        }

        /* The Close Button */
        .close {
            color: white;
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #999;
            text-decoration: none;
            cursor: pointer;
        }

        /* Hide the slides by default */
        .mySlides {
            display: none;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* Caption text */
        .caption-container {
            text-align: center;
            background-color: black;
            padding: 2px 16px;
            color: white;
        }

        img.demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }

        img.hover-shadow {
            transition: 0.3s;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>

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
                        <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="" /></a>
                    </div>
                    <div class="menu--mobile mx-lg-auto">
                        <div class="menu-container d-flex align-items-center justify-content-between d-lg-none px-3 border-bottom py-2 mb-3">
                            <div class="logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="" /></a>
                            </div>
                            <div class="btn-close-header-mobile justify-content-end"><i class="fa-light fa-xmark"></i></div>
                        </div>
                        <div class="menu-container mx-auto menu-nav">
                            <ul class="main-menu">
                                <li class="menu_item"><a class="menu_link" href="{{ url('/') }}">الرئيسية</a></li>
                                <li class="menu_item"><a class="menu_link" data-scroll="section-about">عن المركز</a></li>
                                <li class="menu_item"><a class="menu_link" data-scroll="section-guidelines">الدلائل واللوائح</a></li>
                                <li class="menu_item"><a class="menu_link">تأهيل مزودي الخدمات</a>
                                    <ul class="main-menu-sub">
                                        <li><a>شركات ومكاتب</a></li>
                                        <li><a>مقاولين</a></li>
                                    </ul>
                                </li>
                                <li class="menu_item"><a class="menu_link active">المركز الاعلامي</a>
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
                                <li class="menu_item me-2 me-lg-0"><a class="btn btn-outline-white me-lg-2" href="{{ route('register') }}">تسجيل</a></li>
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
            </div>


        </header>


        <section class="section section-home section-sub-page" id="section-home">
            <div class="container text-center">

                <div class="page-title">{{ $pageTitle }}</div>

            </div>

        </section>
        <!-- end:: section -->
        <section class="section section-sub-page-content" id="section-home">
            <div class="container">
                <div class=" justify-content-center">
                    <div class="col-lg-12 row">
                        @foreach($photos as $key => $item)

                        <div class="guide-links col-md-3 mb-2">
                            <div class="card">
                                @if($item['type'] == 'image' && $item->files->first())
                                <img style="cursor: pointer;width: 100%" id="myImg{{$key}}" onclick='openModal("{{$key}}")'  src="{{ asset('storage/'.$item->files->first()->file) }}" class="card-img-top" alt="...">
                                @endif
                                @if($item['type'] == 'video' && $item->files->first())
                                <video width="100%" height="200" controls>
                                    <source src="{{asset('storage/' . $item->files->first()->file)}}">
                                </video>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item['title']}}</h5>
                                    <p class="card-text"> {{ date('Y/m/d',strtotime($item['created_at'])) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </section>
        <!-- start:: section -->
        <section class="section section-guidelines" id="section-guidelines">
            <div class="container">
                <div class="position-relative">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-6">
                            <div class="swiper-slide">
                                <a href="{{url('/').'/guide/mina'}}" target="_blank" class="widget__item-downlaod text-center">
                                    <h4 class="widget__item-title">ادلة مشعر منى</h4>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="swiper-slide">
                                <a href="{{url('/').'/guide/arafat'}}" target="_blank" class="widget__item-downlaod text-center">
                                    <h4 class="widget__item-title">ادلة مشعر عرفات</h4>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="swiper-slide">
                                <div class="widget__item-downlaod text-center">
                                    <img src="{{ asset('assets/images/mina-qr.png') }}" alt="">
                                    <h4 class="widget__item-title qr">QR موقع مشعر منى</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="swiper-slide">
                                <div class="widget__item-downlaod text-center">
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
                                <div class="col-lg-4 mb-4 mb-lg-0">
                                    <div class="logo mb-lg-4 mb-2"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="" /></div>
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
                                <div class="col-lg-4">
                                    <div class="footer-top-links">
                                        <div class="footer-top-title">مواقع صديقة</div>
                                        <ul class="links">
                                            <li><a href="https://kidana.com.sa" target="_blank">مواقع شركة كدانة</a></li>
                                            <li><a href="https://www.haj.gov.sa" target="_blank">موقع وزارة الحج</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
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
                                    <a href="https://kidana.com.sa" target="_blank" class="d-flex align-items-center justify-content-center justify-content-lg-end image-brand">
                                        <img src="{{ asset('assets/images/footer-kidana-logo.png') }}" alt="" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end:: footer -->


        @foreach($photos as $key => $item)
        <!-- The Modal -->
        <div id="{{$key}}" class="modal">
            <!-- Modal Content (The Image) -->
            <!-- <img style="cursor: pointer;" class="modal-content" id="img01"> -->

            <div class="modal-content">

                @foreach($item->files as $key2 => $item)

                <div class="mySlides{{$key}}">
                    <img onclick="closeModal('{{$key}}')" src="{{asset('storage/' . $item->file)}}" style="width:2000px;height:500px">
                </div>

                @endforeach

                <span class="close cursor" onclick="closeModal('{{$key}}')" style="color: white;">X</span>

                <!-- Next/previous controls -->
                <a class="prev" style="float: left;color:white" onclick="plusSlides(-1 ,'{{$key}}')">&#10094;</a>
                <a class="next" style="float: right; right:1150px;color:white" onclick="plusSlides(1 , '{{$key}}')">&#10095;</a>
            </div>
        </div>

        @endforeach

    </div>
    <!-- end:: Page -->
    <script src="{{ asset('assets/js/script.min.js') }}"></script>
    <script src="{{ asset('assets/js/function.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="jquery.simpleTicker.css" rel="stylesheet">
    <script type="text/javascript">
        $(function() {
            $('#js-news').ticker();
        });

        var modal = document.getElementById("myModal");

        function viewImage(id) {
            // Get the modal

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById(id);
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            img.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }
        }
        // Get the <span> element that closes the modal
        var span = document.getElementById("img01");

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>

    <script>
        var slideIndex = 1;

        // Open the Modal
        function openModal(id) {
            showSlides(1, id);
            document.getElementById(id).style.display = "block";

        }

        // Close the Modal
        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        // var slideIndex = 1;
        // showSlides(slideIndex , '');

        // Next/previous controls
        function plusSlides(n, id) {
            showSlides(slideIndex += n, id);
        }

        // Thumbnail image controls
        function currentSlide(n, id) {
            showSlides(slideIndex = n, id);
        }

        function showSlides(n, id) {
            var i;
            var slides = document.getElementsByClassName("mySlides" + id);
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex - 1].style.display = "block";
        }
    </script>
</body>

</html>