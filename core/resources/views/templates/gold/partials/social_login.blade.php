@php
    $text = isset($register) ? 'Register' : 'Login';
@endphp

<div class="social-auth">
    <div class="auth-devide">
        <span>@lang('OR')</span>
    </div>

    <div class="social-auth-list">
        @if (@gs('socialite_credentials')->google->status == Status::ENABLE)
            <div class="continue-auth-list">
                <a title="@lang($text . ' With Google')" href="{{ route('user.social.login', 'google') }}" class="social-login-btn google-color">
                    <span class="auth-icon">
                        <i class="fa-brands fa-google"></i>
                    </span>
                </a>
            </div>
        @endif
        @if (@gs('socialite_credentials')->facebook->status == Status::ENABLE)
            <div class="continue-auth-list">
                <a title="@lang($text . ' With Facebook')" href="{{ route('user.social.login', 'facebook') }}" class="social-login-btn facebook-color">
                    <span class="auth-icon">
                        <i class="fa-brands fa-facebook-f"></i>
                    </span>
                </a>
            </div>
        @endif
        @if (@gs('socialite_credentials')->linkedin->status == Status::ENABLE)
            <div class="continue-auth-list">
                <a title="@lang($text . ' With linkedin')" href="{{ route('user.social.login', 'linkedin') }}" class="social-login-btn linkedin-color">
                    <span class="auth-icon">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </span>
                </a>
            </div>
        @endif
    </div>
</div>

@push('style')
    <style>
        .social-auth {
            margin-top: 40px
        }

        .auth-devide {
            position: relative;
            text-align: center;
        }

        .auth-devide::after {
            content: "";
            position: absolute;
            height: 1px;
            width: 100%;
            top: 50%;
            left: 0;
            z-index: 1;
            background-color: rgb(240 248 255 / 20%);
        }

        .auth-devide span {
            background: rgb(18 22 34);
            font-size: 16px;
            position: relative;
            z-index: 2;
            padding-inline: 6px;
        }

        .social-auth-list {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 30px;
        }

        .linkedin-color {
            background-color: #0a66c2;
        }

        .google-color {
            background-color: #4285F4;
        }

        .facebook-color {
            background-color: #4267B2;
        }

        .social-login-btn {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            display: grid;
            place-content: center;
            color: white;
        }

        .social-login-btn:hover {
            background-color: var(--main);
            color: #ffffff;
        }
    </style>
@endpush
