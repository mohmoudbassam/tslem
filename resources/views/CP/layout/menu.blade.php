<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @if(auth()->user()->verified==1)
                <li class="menu-title" data-key="t-menu">القوائم</li>

                <li>
                    <a href="{{route('dashboard')}}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard" >الإحصائيات  (قريبا)</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->isAdmin())
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-apps">المستخدمين</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{route('users')}}">
                                    <span data-key="t-calendar">إدارة المستخدمين</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('users.add')}}">
                                    <span data-key="t-chat">إضافة مستخدم</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('users.request')}}">
                                    <span data-key="t-chat">طلبات المستخدمين</span>
                                </a>
                            </li>


                        </ul>
                    </li>
                @endif

                @if(auth()->user()->isAdmin())
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-apps">الإعدادت</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{route('const.index')}}">
                                    <span data-key="t-calendar">الثوابت</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if(auth()->user()->type=='service_provider' && auth()->user()->verified==1)
                    <li>
                        <a href="{{route('services_providers')}}">
                            <i data-feather="users"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->type=='design_office' && auth()->user()->verified==1)
                    <li>
                        <a href="{{route('design_office')}}">
                            <i data-feather="users"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->type=='Delivery' && auth()->user()->verified==1)
                    <li>
                        <a href="{{route('delivery')}}">
                            <i data-feather="users"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                @endif

                    @if(auth()->user()->type=='contractor' && auth()->user()->verified==1)
                    <li>
                        <a href="{{route('contractor')}}">
                            <i data-feather="users"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->type=='consulting_office' && auth()->user()->verified==1)
                    <li>
                        <a href="{{route('consulting_office')}}">

                            <i data-feather="users"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                @endif
            </ul>


        </div>
        <!-- Sidebar -->
    </div>
</div>
