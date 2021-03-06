<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('/'.auth()->user()->type) }}/orders" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24">
                                </span>
                    <span class="logo-lg">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">منصة تسليم</span>
                                </span>
                </a>

                <a href="{{ url('/'.auth()->user()->type) }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24">
                                </span>
                    <span class="logo-lg">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">منصة تسليم</span>
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>


        </div>

        <a href="{{ url('/'.auth()->user()->type) }}/orders" class="logo ps-4">
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="30">
        </a>

        <!-- <div>
            @if(auth()->user()->verified == 0 &&  !auth()->user()->isAdmin() )
                <div class="alert alert-danger">
                    لم يتم اعتماد حسابك بعد
                </div>
            @endif
        </div> -->
        <div class="d-flex">

{{--            <div class="dropdown d-inline-block d-lg-none ms-2">--}}
{{--                <button type="button" class="btn header-item" id="page-header-search-dropdown"--}}
{{--                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    <i data-feather="search" class="icon-lg"></i>--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"--}}
{{--                     aria-labelledby="page-header-search-dropdown">--}}

{{--                    <form class="p-3">--}}
{{--                        <div class="form-group m-0">--}}
{{--                            <div class="input-group">--}}
{{--                                <input type="text" class="form-control" placeholder="بحث"--}}
{{--                                       aria-label="Search Result">--}}

{{--                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}


            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" onclick="read_message()" class="btn header-item noti-icon position-relative"
                        id="page-header-notifications-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    @if(auth()->user()->unreadNotifications()->count())
                        <span class="badge bg-danger rounded-pill"
                              id="notifcation_count">{{auth()->user()->unreadNotifications()->count()}}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> الإشعارات </h6>
                            </div>
                            @if(auth()->user()->unreadNotifications()->count())
                                <div class="col-auto" id="unreade_meassage">
                                    <a href="#" class="small text-reset text-decoration-underline ">
                                        ({{auth()->user()->unreadNotifications()->count()}}) غير مقروء </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        @foreach (auth()->user()->notifications()->take(5)->get() as $notification)

                            <div class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{optional($notification->Notifer)->image}}"
                                             class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{optional($notification->Notifer)->name}}</h6>
                                        <div class="font-size-13 text-muted">
                                            <p class="mb-1">{{$notification->data['data']}}</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                <span>{{$notification->created_at->diffForHumans()}}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>إستعراض المزيد</span>
                        </a>
                    </div>
                </div>
            </div>


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item"
                        id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{auth()->user()->image}}"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{auth()->user()->name}}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    @if(!auth()->user()->isAdmin())
                        <a class="dropdown-item" href="{{route('edit_profile')}}"><i
                                class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> الملف الشخصي</a>
                        <div class="dropdown-divider"></div>
                    @endif

                    <a class="dropdown-item" href="{{route('logout')}}"><i
                            class="mdi mdi-logout font-size-16 align-middle me-1"></i> تسجيل الخروج</a>
                </div>
            </div>

        </div>
    </div>
</header>
