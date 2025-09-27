@extends($activeTemplate . 'layouts.app')
@section('panel')
    @php
        $content = getContent('register.content', true);
    @endphp
    <section class="register-section bg-overlay-primary bg_img" data-background="{{ frontendImage('register', $content->data_values->image, '1920x1080') }}">
        <div class="container">
            <div class="go-to-home">
                <a class="text-white" href="{{ route('home') }}">
                    <i class="la la-times-circle fa-5x"></i>
                </a>
            </div>
            <div class="row register-area justify-content-center align-items-center ">
                <div class="col-lg-5 @if (!gs('registration')) form-disabled @endif">
                    @if (!gs('registration'))
                        <span class="form-disabled-text">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="80" height="80" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M255.999 0c-79.044 0-143.352 64.308-143.352 143.353v70.193c0 4.78 3.879 8.656 8.659 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193c0-42.998 34.981-77.98 77.979-77.98s77.979 34.982 77.979 77.98v70.193c0 4.78 3.88 8.656 8.661 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193C399.352 64.308 335.044 0 255.999 0zM382.04 204.89h-30.748v-61.537c0-52.544-42.748-95.292-95.291-95.292s-95.291 42.748-95.291 95.292v61.537h-30.748v-61.537c0-69.499 56.54-126.04 126.038-126.04 69.499 0 126.04 56.541 126.04 126.04v61.537z" fill="rgb(0 0 0 / 60%)" opacity="1" data-original="rgb(0 0 0 / 60%)" class=""></path>
                                    <path d="M410.63 204.89H101.371c-20.505 0-37.188 16.683-37.188 37.188v232.734c0 20.505 16.683 37.188 37.188 37.188H410.63c20.505 0 37.187-16.683 37.187-37.189V242.078c0-20.505-16.682-37.188-37.187-37.188zm19.875 269.921c0 10.96-8.916 19.876-19.875 19.876H101.371c-10.96 0-19.876-8.916-19.876-19.876V242.078c0-10.96 8.916-19.876 19.876-19.876H410.63c10.959 0 19.875 8.916 19.875 19.876v232.733z" fill="rgb(0 0 0 / 60%)" opacity="1" data-original="rgb(0 0 0 / 60%)" class=""></path>
                                    <path d="M285.11 369.781c10.113-8.521 15.998-20.978 15.998-34.365 0-24.873-20.236-45.109-45.109-45.109-24.874 0-45.11 20.236-45.11 45.109 0 13.387 5.885 25.844 16 34.367l-9.731 46.362a8.66 8.66 0 0 0 8.472 10.436h60.738a8.654 8.654 0 0 0 8.47-10.434l-9.728-46.366zm-14.259-10.961a8.658 8.658 0 0 0-3.824 9.081l8.68 41.366h-39.415l8.682-41.363a8.655 8.655 0 0 0-3.824-9.081c-8.108-5.16-12.948-13.911-12.948-23.406 0-15.327 12.469-27.796 27.797-27.796 15.327 0 27.796 12.469 27.796 27.796.002 9.497-4.838 18.246-12.944 23.403z" fill="rgb(0 0 0 / 60%)" opacity="1" data-original="rgb(0 0 0 / 60%)" class=""></path>
                                </g>
                            </svg>
                        </span>
                    @endif
                    <div class="register-form-area">

                        <div class="register-logo-area text-center">
                            <a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('logo')"></a>
                        </div>

                        <div class="account-header text-center">
                            <h2 class="title">{{ __(@$content->data_values->title) }}</h2>
                            @if (@gs('socialite_credentials')->linkedin->status || @gs('socialite_credentials')->facebook->status == Status::ENABLE || @gs('socialite_credentials')->google->status == Status::ENABLE)
                                <h4 class="title">@lang('Signup With')</h4>
                                @include($activeTemplate . 'partials.social_login')
                            @endif
                        </div>

                        <form class="register-form verify-gcaptcha" action="{{ route('user.register') }}" method="POST">
                            @csrf
                            <div class="row justify-content-center ml-b-20">
                                @if (session()->get('reference') != null)
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="referenceBy">@lang('Reference by')</label>
                                            <input class="form-control" id="referenceBy" name="referBy" type="text" value="{{ session()->get('reference') }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-user"></i></label>
                                        <input class="form-control checkUser" name="firstname" type="text" value="{{ old('firstname') }}" placeholder="@lang('Enter First Name')" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-user"></i></label>
                                        <input class="form-control checkUser" name="lastname" type="text" value="{{ old('lastname') }}" placeholder="@lang('Enter Last Name')" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-envelope"></i></label>
                                        <input class="form-control checkUser" name="email" type="email" value="{{ old('email') }}" placeholder="@lang('Enter Email')" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-key"></i></label>
                                        <input class="form-control @if (gs('secure_password')) secure-password @endif" name="password" type="password" placeholder="@lang('Enter Password')" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-key"></i></label>
                                        <input class="form-control" name="password_confirmation" type="password" placeholder="@lang('Confirm Password')" required>
                                    </div>
                                </div>

                                <x-captcha class="col-lg-12" customCaptchaMarginBottom="mrb-20" googleMarginBottom="mrb-20" />

                                @if (gs('agree'))
                                    @php
                                        $policyPages = getContent('policy_pages.element', false, null, true);
                                    @endphp
                                    <div class="col-lg-12 text-center">
                                        <div class="form-group">
                                            <div class="checkbox-wrapper d-flex align-items-center mt-0 flex-wrap">
                                                <div class="checkbox-item">
                                                    <input id="agree" name="agree" type="checkbox" required>
                                                    <label for="agree">@lang('I agree with')</label>
                                                    <span>
                                                        @foreach ($policyPages as $policy)
                                                            <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12 mb-0">
                                    <div class="form-group">
                                        <button class="submit-btn" type="submit">{{ __(@$content->data_values->button_text) }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="mt-2">@lang('Already Have An Account')? <a href="{{ route('user.login') }}" class="text-base">@lang('Login Now.')</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="existModalCenter" role="dialog" aria-hidden="true" aria-labelledby="existModalCenterTitle" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <strong>@lang('You already have an account please Login ')</strong>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-icon btn-sm" href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

        #referenceBy {
            padding-left: 10px;
        }

        .country {
            padding: 8px 20px 8px 45px;
        }

        /* new css */
        .form-disabled {
            overflow: hidden;
            position: relative;
        }

        .form-disabled::after {
            content: "";
            position: absolute;
            height: 100%;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            top: 0;
            left: 0;
            backdrop-filter: blur(2px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            z-index: 99;
        }

        .form-disabled-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 991;
            font-size: 24px;
            height: auto;
            width: 100%;
            text-align: center;
            color: #000;
            font-weight: 800;
            line-height: 1.2;
        }
    </style>
@endpush

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
@push('script')
    <script>
        "use strict";
        (function($) {
            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                var data = {
                    email: value,
                    _token: token
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
