@php
    $pages = App\Models\Page::where('is_default', Status::NO)
        ->where('tempname', $activeTemplate)
        ->get();

    if (gs('multi_language')) {
        $language = getLanguages();
        $default = getLanguages(true);
    }
    
@endphp

<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('image')"></a>
            <div class="flex-align">
                <div class="d-lg-none d-block">
                    @if (gs('multi_language'))
                        @php
                            $language = App\Models\Language::all();
                            $default = $language->where('code', session('lang'))->first();
                        @endphp

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
                <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span id="hiddenNav"><i class="las la-bars"></i></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('home') }}" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @foreach ($pages as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ menuActive('pages', $item->slug) }}" href="{{ route('pages', ['slug' => $item->slug]) }}">{{ __($item->name) }}</a>
                        </li>
                    @endforeach

                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('plans') }}" href="{{ route('plans') }}">@lang('Plans')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('blog') }}" href="{{ route('blog') }}">@lang('Blogs')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('contact') }}" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>

                    <li class="header-right flex-align">
                        <div class="d-lg-block d-none">
                            @if (gs('multi_language'))
                                @php
                                    $language = App\Models\Language::all();
                                    $default = $language->where('code', session('lang'))->first();
                                @endphp

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
                            @guest
                                @if (gs('registration'))
                                    <a href="{{ route('user.register') }}" class="btn btn-outline--base pill"> <span class="text--gradient">@lang('Register')</span> </a>
                                @endif
                                <a href="{{ route('user.login') }}" class="btn btn--base pill">@lang('Login')</a>
                            @else
                                @if (!request()->routeIs('user*') && !request()->routeIs('ticket*'))
                                    <a href="{{ route('user.home') }}" class="btn btn-outline--base pill"> <span class="text--gradient">@lang('Dashboard')</span> </a>
                                @endif
                                <a href="{{ route('user.logout') }}" class="btn btn--base pill">@lang('Logout')</a>
                            @endguest
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
