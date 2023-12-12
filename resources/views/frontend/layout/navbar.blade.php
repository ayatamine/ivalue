<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0"> لوحة التحكم </h2>
                </a>
            </li>

            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>

        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- @if(auth()->user()->membership_level == 'client')
            <li class="{{ Request::is('/client/dashboard')? 'active': '' }} nav-item"><a href="{{route('client_home')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">الصفحة الرئيسية</span></a>
            </li>
            @else
            <li class="{{ Request::is('/')? 'active': '' }} nav-item"><a href="{{route('home')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">الصفحة الرئيسية</span></a>
            </li>
            @endif --}}

            @if(auth()->user()->membership_level == 'client')
            <li class="nav-item has-sub"><a href="#"><i class="fa fa-building-o"></i><span class="menu-title" data-i18n="Card">الطلبات الأولية</span></a>
                <ul class="menu-content">

                    <li class="{{ Request::is('client/estates')? 'active': '' }}"><a href="{{ route('client.estates.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع الطلبات</span></a>
                    </li>
                    <li class="{{ Request::is('client/estates/create')? 'active': '' }}"><a href="{{ route('client.estates.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">اضافة طلب جديد</span></a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasRole('enter'))
            <li class="nav-item has-sub"><a href="#"><i class="fa fa-building-o"></i><span class="menu-title" data-i18n="Card">الطلبات الأولية</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::is('estates')? 'active': '' }}"><a href="{{ route('estates.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع الطلبات</span></a>
                    </li>
                    <li class="{{ Request::is('estates/create')? 'active': '' }}"><a href="{{ route('estates.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">اضافة طلب جديد</span></a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="nav-item has-sub"><a href="#"><i class="fa fa-building-o"></i><span class="menu-title" data-i18n="Card"> الطلبات المؤرشفة</span></a>
                <ul class="menu-content">
                    @if(auth()->user()->membership_level == 'client')
                    <li class="{{ Request::is('client/archive')? 'active': '' }}"><a href="{{ route('client.archive') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic"> الارشيف</span></a>
                    </li>
                    @else
                    <li class="{{ Request::is('archive')? 'active': '' }}"><a href="{{ route('archive') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic"> الارشيف</span></a>
                    </li>
                   @endif
                </ul>
            </li>
            @if(auth()->user()->membership_level !== 'client')
            <li class="{{ Request::is('drafts')? 'active': '' }} nav-item"><a href="{{route('drafts')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">الطلبات في المسودة</span></a>
            </li>
            @endif
            @if(auth()->user()->hasAnyRole('admin','enter') || auth()->user()->hasAnyPermission(['manage cities','manage countries']))
            <li class="nav-item has-sub {{ (Request::is('countries') ? 'sidebar-group-active' : '' || Request::is('countries/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-globe"></i><span class="menu-title" data-i18n="Card">الموقع الجغرافي</span></a>
                <ul class="menu-content">
                    <li class="nav-item has-sub {{ (Request::is('countries') ? 'sidebar-group-active' : '' || Request::is('countries/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-circle"></i><span class="menu-title" data-i18n="Card">الدول</span></a>
                        <ul class="menu-content">
                            <li class="{{ Request::is('countries')? 'active': '' }}"><a href="{{ route('countries.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع الدول</span></a>
                            </li>
                            <li class="{{ Request::is('countries/create')? 'active': '' }}"><a href="{{ route('countries.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة دولة جديد</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-sub {{ (Request::is('cities') ? 'sidebar-group-active' : '' || Request::is('cities/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-circle"></i><span class="menu-title" data-i18n="Card">المدن</span></a>
                        <ul class="menu-content">
                            <li class="{{ Request::is('cities')? 'active': '' }}"><a href="{{ route('cities.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع المدن</span></a>
                            </li>
                            <li class="{{ Request::is('cities/create')? 'active': '' }}"><a href="{{ route('cities.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة مدينة جديد</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->hasRole('admin'))
            <li class="nav-item has-sub {{ (Request::is('users') ? 'sidebar-group-active' : '' || Request::is('users/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-user-secret"></i><span class="menu-title" data-i18n="Card">إدراة الموظفين</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::is('admins')? 'active': '' }}"><a href="{{ route('admins') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع الموظفين</span></a>
                    </li>
                    <li class="{{ Request::is('users/create')? 'active': '' }}"><a href="{{ route('users.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة موظف جديد</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub {{ (Request::is('users') ? 'sidebar-group-active' : '' || Request::is('users/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-user-secret"></i><span class="menu-title" data-i18n="Card">الصلاحيات والأدوار</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::is('roles')? 'active': '' }}"><a href="{{ route('roles.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic"> الأدوار</span></a>
                    </li>
                    <li class="{{ Request::is('permissions')? 'active': '' }}"><a href="{{ route('permissions.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">الصلاحيات</span></a>
                    </li>
                </ul>
            </li>
            @endif
               @if(auth()->user()->hasAnyRole('admin','enter') || auth()->user()->hasPermissionTo('manage users'))
            <li class="nav-item has-sub {{ (Request::is('users') ? 'sidebar-group-active' : '' || Request::is('users/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-users"></i><span class="menu-title" data-i18n="Card"> العملاء</span></a>
                <ul class="menu-content">
                    <li class="{{ Request::is('users')? 'active': '' }}"><a href="{{ route('users.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع العملاء</span></a>
                    </li>
                    <li class="{{ Request::is('users/create')? 'active': '' }}"><a href="{{ route('users.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة عميل جديد</span></a>
                    </li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->hasRole('admin')  || auth()->user()->hasPermissionTo('view kinds') || auth()->user()->hasPermissionTo('view categories'))
                <li class="nav-item has-sub {{ ((Request::is('kinds') ? 'sidebar-group-active' : '' || Request::is('kinds/*')) ? 'sidebar-group-active' : '' ||  Request::is('categories')) ? 'sidebar-group-active' : ('' || Request::is('categories/*') ? 'sidebar-group-active' : '')}}"><a href="#"><i class="fa fa-bars"></i><span class="menu-title" data-i18n="Card">خصائص العقارات</span></a>
                    <ul class="menu-content">
                        <li class="nav-item has-sub {{ (Request::is('categories') ? 'sidebar-group-active' : '' || Request::is('categories/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-circle"></i><span class="menu-title" data-i18n="Card">التصنيفات</span></a>
                            <ul class="menu-content">
                                <li class="{{ Request::is('categories')? 'active': '' }}"><a href="{{ route('categories.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع التصنيفات</span></a>
                                </li>
                                <li class="{{ Request::is('categories/create')? 'active': '' }}"><a href="{{ route('categories.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة تصنيف جديد</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-sub {{ (Request::is('kinds') ? 'sidebar-group-active' : '' || Request::is('kinds/*')) ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-circle"></i><span class="menu-title" data-i18n="Card">الانواع</span></a>
                            <ul class="menu-content">
                                <li class="{{ Request::is('kinds')? 'active': '' }}"><a href="{{ route('kinds.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع الانواع</span></a>
                                </li>
                                <li class="{{ Request::is('kinds/create')? 'active': '' }}"><a href="{{ route('kinds.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة نوع جديد</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif

            {{--  @if(auth()->user()->hasAnyRole('admin','enter'))--}}
                {{--<li class="nav-item has-sub {{ Request::is('techniques') ? 'sidebar-group-active' : '' || Request::is('techniques/*') ? 'sidebar-group-active' : '' ||  Request::is('technique-types') ? 'sidebar-group-active' : '' || Request::is('technique-types/*') ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-ravelry"></i><span class="menu-title" data-i18n="Card">اساليب التقييم</span></a>--}}
                    {{--<ul class="menu-content">--}}
                        {{--<li class="nav-item has-sub {{ Request::is('categories') ? 'sidebar-group-active' : '' || Request::is('categories/*') ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-circle"></i><span class="menu-title" data-i18n="Card">اساليب التقييم</span></a>--}}
                            {{--<ul class="menu-content">--}}
                                {{--<li class="{{ Request::is('techniques')? 'active': '' }}"><a href="{{ route('techniques.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع الاساليب</span></a>--}}
                                {{--</li>--}}
                                {{--<li class="{{ Request::is('techniques/create')? 'active': '' }}"><a href="{{ route('techniques.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة اسلوب تقييم جديد</span></a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item has-sub {{ Request::is('technique-types') ? 'sidebar-group-active' : '' || Request::is('technique-types/*') ? 'sidebar-group-active' : ''}}"><a href="#"><i class="fa fa-circle"></i><span class="menu-title" data-i18n="Card">الطرق</span></a>--}}
                            {{--<ul class="menu-content">--}}
                                {{--<li class="{{ Request::is('technique-types')? 'active': '' }}"><a href="{{ route('technique-types.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">جميع الطرق</span></a>--}}
                                {{--</li>--}}
                                {{--<li class="{{ Request::is('technique-types/create')? 'active': '' }}"><a href="{{ route('technique-types.create') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">اضافة طريقة جديد</span></a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            {{--@endif--}}

             @if(auth()->user()->hasAnyRole('admin','enter'))
                <li class="nav-item has-sub"><a href="#"><i class="fa fa-ravelry"></i><span class="menu-title" data-i18n="Card">اساليب التقييم</span></a>
                    <ul class="menu-content">
                        <li class="nav-item has-sub"><a href="#"><span class="menu-title" data-i18n="Card">اسلوب السوق</span></a>
                            <ul class="menu-content">
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">طريقه المعاملات المقارنة</span></a>
                                </li>
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">الطريقة الارشادية للمقارنات المتداولة</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-sub {{ (Request::is('investments') ? 'sidebar-group-active' : '' || Request::is('investments/*')) ? 'sidebar-group-active' : '' }}"><a href="#"><span class="menu-title" data-i18n="Card">اسلوب الدخل</span></a>
                            <ul class="menu-content">
                                <li class="{{ Request::is('investments')? 'active': '' }}"><a href="{{ route('investments.index') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">الاستثمار</span></a>
                                </li>
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">طريقة القيمة المتبقية</span></a>
                                </li>
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">طريقة الارباح</span></a>
                                </li>
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">طريقة التدفقات النقدية المخصومة</span></a>
                                </li>
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">معدل الخصم</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-sub"><a href="#"><span class="menu-title" data-i18n="Card">اسلوب التكلفة</span></a>
                            <ul class="menu-content">
                                <li style="margin-left: 1em" class="nav-item has-sub {{ ((Request::is('land') ? 'sidebar-group-active' : '' || Request::is('land/*')) ? 'sidebar-group-active' : '' || Request::is('parking')) ? 'sidebar-group-active' :( '' || Request::is('parking/*') ? 'sidebar-group-active' : '') }}"><a href="#"><i class="feather icon-circle"></i><span class="menu-title" data-i18n="Card">طريقة الاحلال</span></a>
                                    <ul class="menu-content">
                                        <li style="padding-right: 1em" class="{{ Request::is('land')? 'active': '' }}"><a href="{{ route('land.index') }}"><i class="fa fa-minus"></i><span class="menu-item" data-i18n="Basic">ارض مخطط مطور</span></a>
                                        </li>
                                        <li style="padding-right: 1em" class="{{ Request::is('parking')? 'active': '' }}"><a href="{{ route('parking.index') }}"><i class="fa fa-minus"></i><span class="menu-item" data-i18n="Basic">مواقف سيارات</span></a>
                                        </li>
                                        <li style="padding-right: 1em" class="{{ Request::is('petrol_station')? 'active': '' }}"><a href="{{ route('petrol_station.index') }}"><i class="fa fa-minus"></i><span class="menu-item" data-i18n="Basic">محطات الوقود</span></a>
                                        </li>
                                        <li style="padding-right: 1em" class="{{ Request::is('build')? 'active': '' }}"><a href="{{ route('build.index') }}"><i class="fa fa-minus"></i><span class="menu-item" data-i18n="Basic">فيلا - عمارة</span></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">طريقة تكلفه اعادة الانتاج</span></a>
                                </li>
                                <li class=""><a href=""><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">طريقة الجمع</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif

              @if(auth()->user()->hasAnyRole('admin','enter') || auth()->user()->hasPermissionTo('export reports'))
                <li class=""><a href="{{ route('report_page') }}"><i class="feather icon-file"></i><span class="menu-item" data-i18n="Basic">استخراج تقارير</span></a>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- END: Main Menu-->