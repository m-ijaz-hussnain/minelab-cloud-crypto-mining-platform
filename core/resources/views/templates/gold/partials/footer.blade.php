@php
    $footerCaption = getContent('footer.content', true);
    $contactCaption = getContent('contact_us.content', true);
    $pages = App\Models\Page::where('is_default', Status::NO)
        ->where('tempname', $activeTemplate)
        ->get();
    $policyPages = getContent('policy_pages.element', false, null, true);
    $socialElement = getContent('social_icon.element', false, null, true);
@endphp

<footer class="footer-area">
    <div class="pb-60 pt-120">
        <div class="container">
            <div class="footer-item-wrapper flex-wrap">
                <div class="footer-item">
                    <div class="footer-item__logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ siteLogo() }}" alt="@lang('image')">
                        </a>
                    </div>
                    <p class="footer-item__desc">{{ __(@$footerCaption->data_values->short_details) }}</p>
                </div>
                <div class="footer-item">
                    <h4 class="footer-item__title">@lang('Quick Link')</h4>
                    <ul class="footer-menu">
                        @foreach ($pages as $item)
                            <li class="footer-menu__item"><a href="{{ route('pages', ['slug' => $item->slug]) }}" class="footer-menu__link">{{ __($item->name) }}</a></li>
                        @endforeach
                        <li class="footer-menu__item"><a href="{{ route('plans') }}" class="footer-menu__link">@lang('Plans') </a></li>
                        <li class="footer-menu__item"><a href="{{ route('blog') }}" class="footer-menu__link">@lang('Blog')</a></li>
                        <li class="footer-menu__item"><a href="{{ route('contact') }}" class="footer-menu__link">@lang('Contact')</a></li>
                    </ul>
                </div>
                <div class="footer-item">
                    <h4 class="footer-item__title">@lang('Useful Links')</h4>
                    <ul class="footer-menu">
                        @foreach ($policyPages as $page)
                            <li class="footer-menu__item"><a href="{{ route('policy.pages', [slug($page->data_values->title), $page->id]) }}" class="footer-menu__link">{{ __($page->data_values->title) }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-item">
                    <h4 class="footer-item__title">@lang('Contact Info')</h4>
                    <ul class="footer-contact-menu">
                        <li class="footer-contact-menu__item">
                            <span class="icon before-shadow shadow-right flex-center fs-15">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div class="content">
                                <span class="text">{{ @$contactCaption->data_values->contact_details }} </span>
                            </div>
                        </li>
                        <li class="footer-contact-menu__item">
                            <span class="icon before-shadow shadow-right flex-center fs-15">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <div class="content">
                                <a href="mailto:{{ @$contactCaption->data_values->email_address }}" class="text">{{ @$contactCaption->data_values->email_address }}</a>
                            </div>
                        </li>
                        <li class="footer-contact-menu__item">
                            <span class="icon before-shadow shadow-right flex-center fs-15">
                                <i class="fas fa-phone"></i>
                            </span>
                            <div class="content">
                                <a href="tel:{{ @$contactCaption->data_values->contact_number }}" class="text">{{ @$contactCaption->data_values->contact_number }}</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top End-->

    <!-- bottom Footer -->
    <div class="bottom-footer section-bg">
        <div class="container">
            <div class="flex-between gap-3">
                <ul class="social-list">
                    @foreach ($socialElement as $social)
                        <li class="social-list__item">
                            <a href="{{ @$social->data_values->url }}" class="social-list__link flex-center">
                                @php
                                    echo @$social->data_values->social_icon;
                                @endphp
                            </a>
                        </li>
                    @endforeach
                </ul>
                <p class="bottom-footer__text fs-18"> &copy; @lang('Copyright') {{ date('Y') }} . @lang('All rights reserved').</p>
            </div>
        </div>
    </div>
</footer>
