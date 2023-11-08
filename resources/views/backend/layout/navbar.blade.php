<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">القائمة</li>
                <li>
                    <a href="{{ route('backend-home') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        {{--<span class="badge badge-pill badge-success float-right">3</span>--}}
                        <span>لوحة التحكم</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-city"></i>
                        <span>العفارات</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('estates.index') }}">العقارات</a></li>
                        <li><a href="{{ route('infos.create') }}">اضافة عملية لعقار</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-earth"></i>
                        <span>الموقع</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('countries.index') }}">الدولة</a></li>
                        <li><a href="{{ route('cities.index') }}">المدينة</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users"></i>
                        <span>المستخدين</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('users.index') }}">كل المستخدمين</a></li>
                        <li><a href="{{ route('blocked') }}">المستخدمين المحظورين</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('pages.index') }}" class="waves-effect">
                        <i class="far fa-file-alt"></i>
                        <span>الصفحات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sliders.index') }}" class="waves-effect">
                        <i class="fas fa-images"></i>
                        <span>السلايدر الاعلاني</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('send_form') }}" class="waves-effect">
                        <i class="fas fa-paper-plane"></i>
                        <span>ارسال رسالة لبريد</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-money-bill"></i>
                        <span>اداره الاملاك</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('imports') }}">الايرادات</a></li>
                        <li><a href="{{ route('exports') }}">المصاريف</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->