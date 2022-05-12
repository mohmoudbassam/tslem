<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسليم</title>

    <link rel="stylesheet" href="{{ url('assets/landing/css/app.css') }}" />
    <!-- CSS only -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.rtl.5.min.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="stylesheet"
          href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet" />
</head>

<body>
<a role="button" href="#top" id="myBtn" title="Go to top">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up"
         viewBox="0 0 16 16">
        <path fill-rule="evenodd"
              d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
    </svg>
</a>
<div class="page" id="top">
    <div class="page-main">
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="#top">
                        <img style="height: 80px;" src="{{ asset('assets/landing/images/logo.svg') }}" alt="" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto me-3 mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active"  href="#"  aria-current="page" >الرئيسية</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">عن المشروع</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#states">إحصائيات المشروع</a>
                            </li>
                        </ul>
                        <form class="d-flex">


                            <a role="button" href="{{route('register')}}" class="btn btn-outline-main mx-2" type="submit">التسجيل</a>

                            <a role="button" href="{{route('login_page')}}" class="btn btn-main" type="submit">تسجيل الدخول</a>


                        </form>
                    </div>
                </div>
            </nav>

            <section class="header-desc w-full text-center">
                <div class="header-desc-container" data-aos="fade-up">
                    <img class="header-desc-img" src="./assets/img/arrow_background.svg" alt="" />
                    <div class="header-info">
                        <h1>
                            منصة الخدمات الالكترونية <br />
                            لمركز الخدمات الشامل
                        </h1>
                        <p class="text-white">
                            منصة واحدة لجميع القطاعات العاملة في الحج <br />
                            لتقديم خدمة مميزة لحجاج بيت الله الحرام
                        </p>

                        <a class="btn btn-second" href="{{route('login_page')}}">
                            الدخول للمنصة
</a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <section class="about" id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-start" data-aos="fade-left" data-aos-duration="1300">
                    <div class="p-5 pt-0 pr-0">
                        <h1 class="header-text">عن المشروع</h1>
                        <p class="header-text">
                            مركز ريادي متكامل لتقديم الخدمات اللازمة لمزودي خدمات الحج : تسهيل
                            الاجراءات من خلال العمل تحت مظلة واحدة لكافة الجهات. سيحقق هذا
                            المركز الارتقاء
                        </p>
        
                        <div class="services">
                            <div class="mb-4">
                                <h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.371" height="21.374"
                                         viewBox="0 0 21.371 21.374">
                                        <path id="Path_4513" data-name="Path 4513"
                                              d="M57.361,389.732a2.276,2.276,0,0,0-2.214-.593l-.565.151-2.555.685-13.669,3.663a2.268,2.268,0,0,0-1.653,1.767,2.06,2.06,0,0,0-.044.431,2.394,2.394,0,0,0,.714,1.677.677.677,0,0,0,.134.1l7.157,4.191a1.721,1.721,0,0,1,.615.613l4.092,6.919a2.182,2.182,0,0,0,1.708,1.09c.05,0,.1,0,.149,0a2.391,2.391,0,0,0,.6-.079,2.275,2.275,0,0,0,1.62-1.622l1.78-6.647.685-2.555,2.032-7.584A2.271,2.271,0,0,0,57.361,389.732Z"
                                              transform="translate(58.033 410.434) rotate(180)" fill="#b4815a" />
                                    </svg>
                                    خدمة مميزة
                                </h3>
                                <p class="header-text">
                                    نص تجريبي للتصمييم يتم استبداله لاحقا نص تجريبي للتصمييم يتم
                                    استبداله لاحقا
                                </p>
                            </div>
                            <div class="mb-4">
                                <h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.371" height="21.374"
                                         viewBox="0 0 21.371 21.374">
                                        <path id="Path_4513" data-name="Path 4513"
                                              d="M57.361,389.732a2.276,2.276,0,0,0-2.214-.593l-.565.151-2.555.685-13.669,3.663a2.268,2.268,0,0,0-1.653,1.767,2.06,2.06,0,0,0-.044.431,2.394,2.394,0,0,0,.714,1.677.677.677,0,0,0,.134.1l7.157,4.191a1.721,1.721,0,0,1,.615.613l4.092,6.919a2.182,2.182,0,0,0,1.708,1.09c.05,0,.1,0,.149,0a2.391,2.391,0,0,0,.6-.079,2.275,2.275,0,0,0,1.62-1.622l1.78-6.647.685-2.555,2.032-7.584A2.271,2.271,0,0,0,57.361,389.732Z"
                                              transform="translate(58.033 410.434) rotate(180)" fill="#b4815a" />
                                    </svg>
                                    خدمة مميزة
                                </h3>
                                <p class="header-text">
                                    نص تجريبي للتصمييم يتم استبداله لاحقا نص تجريبي للتصمييم يتم
                                    استبداله لاحقا
                                </p>
                            </div>
                            <div class="mb-4">
                                <h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.371" height="21.374"
                                         viewBox="0 0 21.371 21.374">
                                        <path id="Path_4513" data-name="Path 4513"
                                              d="M57.361,389.732a2.276,2.276,0,0,0-2.214-.593l-.565.151-2.555.685-13.669,3.663a2.268,2.268,0,0,0-1.653,1.767,2.06,2.06,0,0,0-.044.431,2.394,2.394,0,0,0,.714,1.677.677.677,0,0,0,.134.1l7.157,4.191a1.721,1.721,0,0,1,.615.613l4.092,6.919a2.182,2.182,0,0,0,1.708,1.09c.05,0,.1,0,.149,0a2.391,2.391,0,0,0,.6-.079,2.275,2.275,0,0,0,1.62-1.622l1.78-6.647.685-2.555,2.032-7.584A2.271,2.271,0,0,0,57.361,389.732Z"
                                              transform="translate(58.033 410.434) rotate(180)" fill="#b4815a" />
                                    </svg>
                                    خدمة مميزة
                                </h3>
                                <p class="header-text">
                                    نص تجريبي للتصمييم يتم استبداله لاحقا نص تجريبي للتصمييم يتم
                                    استبداله لاحقا
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="col-md-6 about-container" data-aos="fade-right" data-aos-duration="1300">
                    <img src="{{ asset('assets/landing/images/left-image.png') }}" class="img-fluid" alt="" />
                </h1>
            </div>
        </div>
    </section>

    <section id="states">
        <div class="states-main">
            <div class="container">
                <div class="row statistics">
                    <div class="text-center col text-center stats-card" data-aos="fade-up" data-aos-duration="1300">
                        <img src="./assets/svgs/workers.svg" class="states-icon" />
                        <h3 class="text-white mt-2 text-number">+1550</h3>
                        <p class="text-white">عدد المقاولين</p>
                    </div>
                    <div class="text-center col text-center stats-card" class="states-icon" data-aos="fade-up"
                         data-aos-duration="1400">
                        <img src="./assets/svgs/consultation.svg" />
                        <h3 class="text-white text-number mt-2">+1550</h3>
                        <p class="text-white">عدد المقاولين</p>
                    </div>
                    <div class="text-center col text-center stats-card" data-aos="fade-up" data-aos-duration="1500">
                        <img src="./assets/svgs/sketch.svg" class="states-icon" />
                        <h3 class="text-white mt-2 text-number">+1550</h3>
                        <p class="text-white">عدد المقاولين</p>
                    </div>
                    <div class="text-center col text-center stats-card" data-aos="fade-up" data-aos-duration="1600">
                        <img src="./assets/svgs/team.svg" data-aos-duration="1400" />
                        <h3 class="text-white mt-2 text-number">+1550</h3>
                        <p class="text-white">عدد المقاولين</p>
                    </div>
                    <div class="text-center col text-center stats-card" data-aos="fade-up" data-aos-duration="1700">
                        <img src="./assets/svgs/office-worker.svg" class="states-icon" />
                        <h3 class="text-white mt-2 text-number">+1550</h3>
                        <p class="text-white">عدد المقاولين</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="info">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 my-4 right d-flex justify-content-center justify-content-md-start" data-aos="fade-left">
                    <div>
                        <div class="d-flex justify-content-center justify-content-md-start">
                            <img style="height: 100px;" src="{{ asset('assets/landing/images/logo.svg') }}" alt="" />
                        </div>
                        <div class="d-flex justify-content-center justify-content-md-start">
                            <p class="header-text my-2">
                                هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة
                            </p>
</div>
                            <div class="d-flex mt-4 justify-content-center justify-content-md-start">
                                <a role="button" class="social-icon btn btn-primary">
                                    <i class="la la-facebook"></i>
                                </a>
                                <a role="button" class="social-icon btn btn-primary">
                                    <i class="lab la-twitter"></i>
                                </a>
                                <a role="button" class="social-icon btn btn-primary">
                                    <i class="la la-youtube"></i>
                                </a>
                                <a role="button" class="social-icon btn btn-primary">
                                    <i class="la la-instagram"></i>
                                </a>
                            </div>
                    </div>    
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <h1 class="text-white">حمل التطبيق مجانا</h1>
                    <div class="d-flex justify-content-center justify-content-md-end stores">
                        <a role="button" class="me-2">
                            <img src="{{ asset('assets/img/google play.png') }}" alt="" />
                        </a>
                        <a role="button">
                            <img src="{{ asset('assets/img/appstore.png') }}" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7 p-0 d-flex justify-content-md-start justify-content-center">
                <div class="text-muted">جميع الحقوق محفوظة لدى تسليم © {{ date('Y') }}</div>
            </div>
            <div class="col-md-5 d-flex justify-content-md-end justify-content-center pt-3 pt-md-0">
                <div class="row logos">
                    <div class="col-6">
                        <img class="img-fluid" alt="" src="{{ asset('assets/landing/images/rcmc.png') }}" />
                    </div>
                    <div class="col-6">
                        <img class="img-fluid" alt="" src="{{ asset('assets/landing/images/kidana.png') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript Bundle with Popper -->
<script src="{{ url('/assets/js/bootstrap_bundle.5.min.js') }}"></script>
<script src="{{ url('/assets/js/main.js') }}"></script>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>

</html>
