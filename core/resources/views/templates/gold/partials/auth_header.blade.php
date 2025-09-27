@php
    if (gs('multi_language')) {
        $language = getLanguages();
        $default = getLanguages(true);
    }
@endphp
<header class="header dashboard-header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('image')"></a>
            <div class="flex-align">
                <div class="d-lg-none d-block">
                    @if (gs('multi_language'))
                        <div class="language dropdown">
                            <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="language-content">
                                    <div class="language_flag">
                                        <img src="{{ getImage(getFilePath('language') . '/' . $default->image, getFileSize('language')) }}" alt="">
                                    </div>
                                    <p class="language_text_select">{{ __($default->name) }}</p>
                                </div>
                                <span class="collapse-icon"><i class="las la-angle-down"></i></span>
                            </button>
                            <div class="dropdown-menu langList_dropdow py-2" style="">
                                <ul class="langList">
                                    @foreach ($language->where('code', '!=', $default->code) as $lang)
                                        <li>
                                            <a href="{{ route('lang', $lang->code) }}" class="language-list">
                                                <div class="language_flag">
                                                    <img src="{{ getImage(getFilePath('language') . '/' . $lang->image, getFileSize('language')) }}" alt="flag">
                                                </div>
                                                <p class="language_text">{{ __($lang->name) }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <button class="navbar-toggler header-button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span id="hiddenNav"><i class="las la-bars"></i></span>
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu align-items-lg-center ms-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"> @lang('Mining') <span class="nav-item__icon"><i class="las la-angle-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.plans') }}">@lang('Start Mining')</a></li>
                            <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.plans.purchased') }}">@lang('Mining Tracks')</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"> @lang('Withdraw') <span class="nav-item__icon"><i class="las la-angle-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                            <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.withdraw.history') }}">@lang('My Withdrawals')</a>
                            </li>
                        </ul>
                    </li>
                    @if (gs('referral_system'))
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"> @lang('Referral') <span class="nav-item__icon"><i class="las la-angle-down"></i></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.referral') }}">@lang('My Referral')</a></li>
                                <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.referral.log') }}">@lang('Referral Bonus Logs')</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"> @lang('Support Ticket') <span class="nav-item__icon"><i class="las la-angle-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('ticket.open') }}">@lang('Open Ticket')</a>
                            <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('ticket.index') }}">@lang('All Tickets')</a></li>
                    </li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">@lang('My Account') <span class="nav-item__icon"><i class="las la-angle-down"></i></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.badge') }}">@lang('Achievements')</a></li>
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.profile.setting') }}">@lang('Profile Setting')</a></li>
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.wallets') }}">@lang('Wallets')</a></li>
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.payment.history') }}">@lang('Payments Log')</a></li>
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>
                        <li class="dropdown-menu__list"><a class="dropdown-item dropdown-menu__link" href="{{ route('user.logout') }}">@lang('Logout')</a></li>


                    </ul>
                </li>
                <li class="header-right flex-align">
                    <div class="d-lg-block d-none">
                        @if (gs('multi_language'))
                            <div class="language dropdown">
                                <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="language-content">
                                        <div class="language_flag">
                                            <img src="{{ getImage(getFilePath('language') . '/' . $default->image, getFileSize('language')) }}" alt="">
                                        </div>
                                        <p class="language_text_select">{{ __($default->name) }}</p>
                                    </div>
                                    <span class="collapse-icon"><i class="las la-angle-down"></i></span>
                                </button>
                                <div class="dropdown-menu langList_dropdow py-2" style="">
                                    <ul class="langList">
                                        @foreach ($language->where('code', '!=', $default->code) as $lang)
                                            <li>
                                                <a href="{{ route('lang', $lang->code) }}" class="language-list">
                                                    <div class="language_flag">
                                                        <img src="{{ getImage(getFilePath('language') . '/' . $lang->image, getFileSize('language')) }}" alt="flag">
                                                    </div>
                                                    <p class="language_text">{{ __($lang->name) }}</p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="account-buttons flex-align">
                        <a class="btn btn--base pill" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                    </div>
                </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

@push('style')
    <style>
        .language-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 5px 12px;
            border-radius: 4px;
            width: max-content;
            height: 38px;
        }

        .language_flag {
            flex-shrink: 0
        }

        .language_flag img {
            height: 20px;
            width: 20px;
            object-fit: cover;
            border-radius: 50%;
        }

        .language-wrapper.show .collapse-icon {
            transform: rotate(180deg)
        }

        .collapse-icon {
            font-size: 14px;
            display: flex;
            transition: all linear 0.2s;
            color: hsl(var(--white));
        }

        .language_text_select {
            font-size: 14px;
            font-weight: 400;
            color: #ffffff;
        }

        .language-content {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .language_text {
            color: #ffffff
        }

        .language-list {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            cursor: pointer;
        }

        .language .dropdown-menu {
            position: absolute;
            -webkit-transition: ease-in-out 0.1s;
            transition: ease-in-out 0.1s;
            opacity: 0;
            visibility: hidden;
            top: 100%;
            display: unset;
            background: #2a313b;
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
            min-width: 150px;
            padding: 7px 0 !important;
            border-radius: 8px;
            border: 1px solid rgb(255 255 255 / 10%);
        }

        .language .dropdown-menu.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
@endpush
