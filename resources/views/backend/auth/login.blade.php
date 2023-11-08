<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from nazox-rtl.laravel.themesdesign.in/login by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Sep 2020 22:13:22 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>لوحة التحكم | الزغيبي</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('backend') }}/assets/css/icons.min.css" id="icons-style" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('backend') }}/assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="auth-body-bg">
{{--<div class="home-btn d-none d-sm-block">--}}
    {{--<a href="/"><i class="mdi mdi-home-variant h2 text-white"></i></a>--}}
{{--</div>--}}
<div>
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-4">
                <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                    <div class="w-100">
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div>
                                    <div class="text-center">
                                        <div>
                                            <a class="logo">
                                                <img src="{{ asset('backend') }}/assets/images/logo.png" width="200" alt="logo"></a>
                                        </div>

                                        <h4 class="font-size-18 mt-4">مرحبا بكــ !</h4>
                                        <p class="text-muted">قم بملئ الحقول للدخول الى لوحه التحكم الخاصة بكــ.</p>
                                    </div>

                                    <div class="p-2 mt-5">
                                        @include('common.done')
                                        <form method="POST" action="{{ route('backendLogin') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group auth-form-group-custom mb-4">
                                                <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                <label for="email">البريد الالكتروني</label>
                                                <input id="email" type="email" class="form-control" name="email"
                                                        required autocomplete="email"
                                                       placeholder="البريد الالكتروني">
                                            </div>

                                            <div class="form-group auth-form-group-custom mb-4">
                                                <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                <label for="password">كلمة المرور</label>
                                                <input type="password" class="form-control" name="password" required
                                                       autocomplete="current-password" id="password"
                                                       placeholder="كلمة المرور">
                                            </div>
                                            <div class="mt-4 text-center">
                                                <button class="btn btn-primary w-md waves-effect waves-light"
                                                        type="submit">تسجيل الدخول
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-5 text-center">
                                        <p>Crafted with <i class="mdi mdi-heart text-danger"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="authentication-bg">
                    <div class="bg-overlay"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>