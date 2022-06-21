<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">القوائم</li>

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
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="settings"></i>
                            <span data-key="t-apps">الإعدادت</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{route('const.index')}}">
                                    <span data-key="t-calendar">الثوابت</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('service.index')}}">
                                    <span data-key="t-calendar">الخدمات</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if(auth()->user()->type=='service_provider' )
                    <li>
                        <a href="{{route('services_providers')}}">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->type=='design_office' )
                    <li>
                        <a href="{{route('design_office')}}">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->type=='Delivery')
                    <li>
                        <a href="{{route('delivery')}}">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="layers"></i>
                            <span data-key="t-apps">الزيارات الميدانية</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{route('delivery.reports')}}">
                                    <span data-key="t-calendar">إدارة الزيارات الميدانية</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('delivery.report_add_form')}}">
                                    <span data-key="t-chat">إضافة تقرير زيارة</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                 
                @endif

                @if(auth()->user()->type=='contractor')
                    <li>
                        <a href="{{route('contractor')}}">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->type=='consulting_office')
                    <li>
                        <a href="{{route('consulting_office')}}">

                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="layers"></i>
                            <span data-key="t-apps">تقارير الإشراف </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{route('consulting_office.reports')}}">
                                    <span data-key="t-calendar">إدارة تقارير الإشراف  </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('consulting_office.report_add_form')}}">
                                    <span data-key="t-chat">إضافة تقرير إشراف</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                @endif
                    @if(auth()->user()->verified==1)


                        <li>
                            <a href="{{route('dashboard')}}">
                                <i data-feather="pie-chart"></i>
                                <span data-key="t-dashboard">الإحصائيات  (قريبا)</span>
                            </a>
                        </li>
                    @endif

                @if(!auth()->user()->isAdmin())
                    <li>
                        <a href="{{route('edit_profile')}}">

                            <i data-feather="info"></i>
                            <span data-key="t-authentication">معلوماتي</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{route('logout')}}">

                        <i class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                        <span data-key="t-authentication">تسجيل الخروج</span>
                    </a>
                </li>


            </ul>


        </div>
        <!-- Sidebar -->
    </div>
</div>
