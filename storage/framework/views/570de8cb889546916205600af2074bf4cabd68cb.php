<div class="cp-right-menu">
    <a href="#" class="cp-right-menu-logo">
        <div class="close-menu d-lg-none p-2">
            <i class="far fa-times"></i>
        </div>
        <img src="<?php echo e(asset('assets/images/logo-dark.png')); ?>" alt="" height="38">
    </a>
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <?php if(auth()->user()->isAdmin()): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-apps">المستخدمين</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="<?php echo e(route('users')); ?>">
                                    <span data-key="t-calendar">إدارة المستخدمين</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('users.add')); ?>">
                                    <span data-key="t-chat">إضافة مستخدم</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('users.request')); ?>">
                                    <span data-key="t-chat">طلبات المستخدمين</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="licenses"></i>
                            <span data-key="t-apps"><?php echo e(\App\Models\License::trans('group')); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="<?php echo e(route('licenses')); ?>">
                                    <span data-key="t-calendar"><?php echo e(\App\Models\License::crudTrans('index')); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('licenses.add')); ?>">
                                    <span data-key="t-chat"><?php echo e(\App\Models\License::crudTrans('add')); ?></span>
                                </a>
                            </li>
                            <?php if(request()->routeIs('licenses.edit')): ?>
                                <li>
                                    <a onclick="event.preventDefault(); return false" href="<?php echo e(route('licenses.edit',['license'=>request()->license])); ?>">
                                        <span data-key="t-chat"><?php echo e(\App\Models\License::crudTrans('update')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li> -->
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="settings"></i>
                            <span data-key="t-apps">الإعدادت</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="<?php echo e(route('const.index')); ?>">
                                    <span data-key="t-calendar">الثوابت</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('service.index')); ?>">
                                    <span data-key="t-calendar">الخدمات</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('news')); ?>">
                                    <span data-key="t-calendar">الاخبار</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('specialties.index')); ?>">
                                    <span data-key="t-calendar">التخصصات</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(auth()->user()->type=='service_provider' ): ?>
                    <li>
                        <a href="<?php echo e(route('services_providers.orders')); ?>">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(auth()->user()->type=='design_office' ): ?>
                    <li>
                        <a href="<?php echo e(route('design_office.orders')); ?>">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(auth()->user()->type=='Delivery'): ?>
                    <li>
                        <a href="<?php echo e(route('delivery')); ?>">
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
                                <a href="<?php echo e(route('delivery.reports')); ?>">
                                    <span data-key="t-calendar">إدارة الزيارات الميدانية</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('delivery.report_add_form')); ?>">
                                    <span data-key="t-chat">إضافة تقرير زيارة</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                <?php endif; ?>

                <?php if(auth()->user()->type=='raft_company'): ?>
                    <li>
                        <a href="<?php echo e(route('raft_company')); ?>">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">المراكز</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('session')); ?>">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">قائمة المواعيد</span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(auth()->user()->type=='contractor'): ?>
                    <li>
                        <a href="<?php echo e(route('contractor.orders')); ?>">
                            <i data-feather="list"></i>
                            <span data-key="t-authentication">الطلبات</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(auth()->user()->type=='consulting_office'): ?>
                    <li>
                        <a href="<?php echo e(route('consulting_office')); ?>">

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
                                <a href="<?php echo e(route('consulting_office.reports')); ?>">
                                    <span data-key="t-calendar">إدارة تقارير الإشراف  </span>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('consulting_office.report_add_form')); ?>">
                                    <span data-key="t-chat">إضافة تقرير إشراف</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                <?php endif; ?>
                <?php if(auth()->user()->isAdmin()): ?>


                    <li>
                        <a href="<?php echo e(route('dashboard')); ?>">
                            <i data-feather="pie-chart"></i>
                            <span data-key="t-dashboard">الإحصائيات </span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(!auth()->user()->isAdmin()): ?>
                    <li>
                        <a href="<?php echo e(route('edit_profile')); ?>">

                            <i data-feather="info"></i>
                            <span data-key="t-authentication">معلوماتي</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo e(route('logout')); ?>">

                        <i class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                        <span data-key="t-authentication">تسجيل الخروج</span>
                    </a>
                </li>


            </ul>


        </div>
        <!-- Sidebar -->
    </div>
</div>
<?php /**PATH C:\wamp64\www\taslem\resources\views/CP/layout/menu.blade.php ENDPATH**/ ?>