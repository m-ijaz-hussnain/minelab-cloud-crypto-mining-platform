@php
    $content = getContent('login.content', true);
@endphp
@extends($activeTemplate . 'layouts.app')
@section('panel')
    <section class="account bg-img" data-background-image="{{ frontendImage('login' , @$content->data_values->image, '1235x980') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-10">
                    <div class="account-form">
                        <div class="account-form__logo text-center">
                            <a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('image')"></a>
                        </div>
                        <h4 class="account-form__title"> {{ __(@$content->data_values->title) }} </h4>
                        <form class="verify-gcaptcha" method="POST" action="{{ route('user.login') }}" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="Username" class="form--label">@lang('Username')</label>
                                        <div class="position-relative">
                                            <input type="text" class="form--control" id="Username" name="username" value="{{ old('username') }}" required>
                                            <span class="input-icon"><i class="far fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="your-password" class="form--label">@lang('Password')</label>
                                        <div class="position-relative">
                                            <input id="your-password" class="form-control form--control" name="password" type="password" required>
                                            <span class="input-icon"><span class="icon-Lock"></span></span>
                                            <span class="password-show-hide icon-eye toggle-password icon-eye-off" id="#your-password"></span>
                                        </div>
                                    </div>
                                </div>
                                <x-captcha />
                                <div class="col-sm-12 form-group">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">@lang('Remember me') </label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="forgot-password">@lang('Forgot Your Password')?</a>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline--base w-100"> <span class="text--gradient">@lang('Submit')</span> </button>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang('Don\'t Have An Account Yet')? <a href="{{ route('user.register') }}" class="have-account__link text--gradient fw-bold">@lang('Create Account')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if (@gs('socialite_credentials')->linkedin->status || @gs('socialite_credentials')->facebook->status == Status::ENABLE || @gs('socialite_credentials')->google->status == Status::ENABLE)
                            @include($activeTemplate . 'partials.social_login')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = `<span style="color:red;">@lang('Captcha field is required.')</span>`;
                return false;
            }

            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
