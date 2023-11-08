@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'التسجيل')
@else
    @section('pageTitle', 'Login & Register')
@endif
@section('frontend-main')
    <section class="login-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="login-wrap">
                        <div class="login-html">
                            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">@lang('trans.sign_in')</label>
                            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">@lang('trans.sign_up')</label>
                            <div class="login-form">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="sign-in-htm">
                                        <div class="group">
                                            <label for="user" class="label">@lang('trans.name')</label>
                                            <input type="text" name="email" value="{{ old('email') }}" class="input">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="pass" class="label">@lang('trans.password')</label>
                                            <input name="password" required autocomplete="current-password" type="password" class="input" data-type="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <input id="check" name="remember" type="checkbox" class="check" {{ old('remember') ? 'checked' : '' }}>
                                            <label for="check"><span class="icon"></span>@lang('trans.name')</label>
                                        </div>
                                        <div class="group">
                                            <input  style="color:white" type="submit" class="button" value="@lang('trans.sign_in')">
                                        </div>
                                        <div class="hr"></div>

                                        <div class="foot-lnk">
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    @lang('trans.forget_pass')
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                                <div class="sign-up-htm">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="group">
                                            <label for="user" class="label">@lang('trans.name')</label>
                                            <input type="text" name="name"  value="{{ old('name') }}" class="input">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                         </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="pass" class="label">@lang('trans.password')</label>
                                            <input type="password" class="input" data-type="password" name="password" required autocomplete="new-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="pass" class="label">@lang('trans.confirm_password')</label>
                                            <input type="password" class="input" data-type="password" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                        <div class="group">
                                            <label for="pass" class="label">@lang('trans.email')</label>
                                            <input type="text" name="email" value="{{ old('email') }}" class="input">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <input  style="color:white" type="submit" class="button" value="@lang('trans.sign_up')">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection
