<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        ul.social {
            margin: 0;
            padding: 0;
        }

        ul.social li {
            list-style: none;
            display: inline-block;
        }

        ul.social li a {
            position: relative;
            width: 40px;
            height: 40px;
            display: block;
            text-align: center;
            margin: 0 2px;
            border-radius: 50%;
            padding: 6px;
            box-sizing: border-box;
            text-decoration: none;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
            background: linear-gradient(0deg, #ddd, #fff);
            transition: .5s;
        }

        ul.social li a:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-decoration: none;
        }

        ul.social li a .fa {
            widht: 100%;
            height: 100%;
            display: block;
            background: linear-gradient(0deg, #fff, #ddd);
            border-radius: 50%;
            line-height: calc(40px - 12px);
            font-size: 20px;
            color: #262626;
            transition: .5s;
        }

        ul.social li:nth-child(1) a:hover .fa {
            color: #3b5998;
        }

        ul.social li:nth-child(2) a:hover .fa {
            color: #00aced;
        }

        ul.social li:nth-child(3) a:hover .fa {
            color: #dd4b39;
        }

        ul.social li:nth-child(4) a:hover .fa {
            color: #007bb6;
        }

        ul.social li:nth-child(5) a:hover .fa {
            color: #34e428;
        }

        ul.social li:nth-child(6) a:hover .fa {
            color: #2d2be4;
        }

        ul.social li:nth-child(6) a:hover .fa {
            color: #ee3f4e;
        }

        ul.social li:nth-child(7) a:hover .fa {
            color: #671b23;
        }
    </style>
    @include('frontend.layout.head')
</head>
<body class="vertical-layout vertical-menu-modern @if(Auth::user()->dark_mode == 1) dark-layout @endif 2-columns  navbar-floating footer-static  "
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="dark-layout">
<input type="hidden" value="{{URL::to('/')}}" id="base_url">
<!--Preloader-->
<div class="preloader-it">
    <div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active pimary-color-red">
    <!-- Top Menu Items -->
@include('frontend.layout.header')
<!-- Left Sidebar Menu -->
@include('frontend.layout.navbar')
<!-- /Left Sidebar Menu -->
    <!-- Main Content -->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @include('common.done')
                @section('frontend-main')
                @show
            </div>
        </div>
    </div>
    <!-- /Main Content -->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="social"><?php $option = \App\Models\Option::find(1); ?>
                        @if(!empty($option->face))
                            <li><a href="{{ $option->face }}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        @endif
                        @if(!empty($option->twitter))
                            <li><a href="{{ $option->twitter }}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            </li>
                        @endif
                        @if(!empty($option->youtube))
                            <li><a href="{{ $option->youtube }}"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                            </li>
                        @endif
                        @if(!empty($option->insta))
                            <li><a href="{{ $option->insta }}"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </li>
                        @endif
                        @if(!empty($option->whats))
                            <li><a href="whatsapp://send?abid={{ $option->whats }}&text=Hello!"><i
                                            class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                        @endif
                        @if(!empty($option->phone))
                            <li><a href="tel:{{ $option->phone }}"><i class="fa fa-phone" aria-hidden="true"></i></a>
                            </li>
                        @endif
                        @if(!empty($option->email))
                            <li><a href="mailto:{{ $option->email }}"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i
                        class="feather icon-heart pink"></i></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i>
            </button>
        </p>
    </footer>
    <!-- END: Footer-->
</div>
<!-- /#wrapper -->
@if(Auth::user()->dark_mode == 0)
    <script>
        document.getElementById("light_btn").style.display = "none";
    </script>
@else
    <script>
        document.getElementById("dark_btn").style.display = "none";
    </script>
@endif
@include('frontend.layout.footer')
</body>
</html>