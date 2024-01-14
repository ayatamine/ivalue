<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav @if(auth()->check() && Auth::user()->dark_mode == 1) navbar-dark @else navbar-light @endif navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon feather icon-menu"></i></a></li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon feather icon-maximize"></i></a></li>
                    @if(auth()->user()->membership_level == 'admin')
                    <li class="nav-item d-none d-lg-block">
                        <a href="{{ route('settings',Route::current()->parameter('subdomain')) }}" class="nav-link nav-link-label"><i
                                    class="ficon feather icon-settings"></i></a>
                    </li>
                    @endif
                    <li class="nav-item d-none d-lg-block">
                        <a title="تفعيل الوضع الليلي" class="nav-link nav-link-label" ad="{{ Auth::user()->id }}"
                           role="button" style="cursor: pointer" id="dark_btn" data-token="{{ csrf_token() }}"><i
                                    class="ficon feather icon-moon"></i></a>
                        <a title="تفعيل الوضع النهاري" class="nav-link nav-link-label" ad="{{ Auth::user()->id }}"
                           role="button" style="cursor: pointer" id="light_btn" data-token="{{ csrf_token() }}"><i
                                    class="ficon feather icon-sun"></i></a>
                    </li>
                    {{--<li class="nav-item d-none d-lg-block">--}}
                    {{--<a href="{{ route('edit_pro',Route::current()->parameter('subdomain')) }}" title="معلومات الدخول" class="nav-link nav-link-label" role="button" style="cursor: pointer"><i class="ficon fa fa-cog"></i></a>--}}
                    {{--</li>--}}
                    <?php
                    $nots = \App\Models\DashNotification::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
                    ?>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"
                                                                           aria-expanded="true"><i
                                    class="ficon feather icon-bell"></i><span
                                    class="badge badge-pill badge-primary badge-up">{{ $nots->count() }}</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white">{{ $nots->count() }} اشعارات</h3><span class="notification-title">جديدة</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list ps">
                                @if($nots->count() > 0)
                                @foreach($nots as $key => $not)
                                <a class="d-flex justify-content-between" href="{{ route('not_open' , ['not_id'=>$not->id,'subdomain'=> Route::current()->parameter('subdomain')]) }}">
                                    <div class="media d-flex align-items-start">
                                        <div style="display: flex;align-items: center;height: 100%" class="media-left">
                                            <i style="color: {{ $not->color }}" class="{!! $not->icon !!} font-medium-5"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 style="color: {{ $not->color }}" class="media-heading">اشعار جديد لك </h6>
                                            <small class="notification-text"> {{ $not->title ? $not->title : '' }}</small>
                                        </div>
                                        <small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">{{$not->created_at->diffForHumans()}}
                                            </time>
                                        </small>
                                    </div>
                                </a>
                                @endforeach
                                @else
                                    <a class="d-flex justify-content-center" href="javascript:void(0)">
                                        <div class="media d-flex align-items-center">
                                            <div style="display: flex;align-items: center;height: 100%" class="media-left"><i
                                                        class="fa fa-times font-medium-5 warning"></i></div>
                                            <div class="media-body">
                                                <h6 class="primary media-heading">لا يوجد اشعارات جديدة</h6>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; left: -7px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </li>
                            {{--<li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center"--}}
                                                                {{--href="javascript:void(0)">Read all notifications</a>--}}
                            {{--</li>--}}
                        </ul>
                    </li>
                    <li title="تسجيل خروج" class="nav-item d-none d-lg-block">
                        <a class="nav-link nav-link-label" href="{{ route('logout',Route::current()->parameter('subdomain')) }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                    class="ficon feather icon-log-out"></i></a>
                        <form id="logout-form" action="{{ route('logout', Route::current()->parameter('subdomain')) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span
                                        class="user-name text-bold-600">{{--{{ Auth::user()->name }}--}}</span><span
                                        class="user-status"></span></div>
                            <span>{{--<img class="round" src="{{ asset('backend') }}/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40">--}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- END: Header-->