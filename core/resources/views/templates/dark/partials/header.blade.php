@php
    $contactCaption = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('is_default', Status::NO)
        ->where('tempname', $activeTemplate)
        ->get();

    if (gs('multi_language')) {
        $language = getLanguages();
        $default = getLanguages(true);
    }
@endphp

<header class="header-bottom" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}">
                <img src="{{ siteLogo() }}" alt="Logo">
            </a>
            <button class="navbar-toggler header-button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu m-auto">
                    <li class="nav-item"><a class="nav-link {{ menuActive('home') }}"
                            href="{{ route('home') }}">@lang('Home')</a></li>
                    @foreach ($pages as $item)
                        <li class="nav-item"><a class="nav-link {{ menuActive('pages', $item->slug) }}"
                                href="{{ route('pages', ['slug' => $item->slug]) }}">{{ __($item->name) }}</a></li>
                    @endforeach

                    <li class="nav-item"><a class="nav-link {{ menuActive('plans') }}"
                            href="{{ route('plans') }}">@lang('Mining Plans')</a></li>
                    <li class="nav-item"><a class="nav-link {{ menuActive('blog') }}"
                            href="{{ route('blog') }}">@lang('Blogs')</a></li>
                    <li class="nav-item"><a class="nav-link {{ menuActive('contact') }}"
                            href="{{ route('contact') }}">@lang('Contact')</a></li>
                </ul>

                <div
                    class="langauge-registration d-flex flex-wrap flex-lg-nowrap align-items-center justify-content-between">
                    @if (gs('multi_language'))
                        <div class="language dropdown">
                            <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="language-content">
                                    <div class="language_flag">
                                        <img src="{{ getImage(getFilePath('language') . '/' . $default->image, getFileSize('language')) }}"
                                            alt="">
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
                                                    <img src="{{ getImage(getFilePath('language') . '/' . $lang->image, getFileSize('language')) }}"
                                                        alt="flag">
                                                </div>
                                                <p class="language_text">{{ __($lang->name) }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex align-items-center gap-sm-0 user-btn-group flex-wrap gap-1">
                        @guest
                            @if (gs('registration'))
                                <a class="btn--base btn--sm ms-sm-3 register-btn ms-0 outline"
                                    href="{{ route('user.register') }}">@lang('Register')</a>
                            @endif
                            <a class="btn--base btn--sm ms-sm-3 ms-0"
                                href="{{ route('user.login') }}">@lang('Login')</a>
                        @else
                            @if (!request()->routeIs('user*') && !request()->routeIs('ticket*'))
                                <a class="btn--base btn--sm ms-sm-3 ms-0"
                                    href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            @endif
                            <a class="btn btn--danger btn--sm ms-sm-3 ms-0"
                                href="{{ route('user.logout') }}">@lang('Logout')</a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
