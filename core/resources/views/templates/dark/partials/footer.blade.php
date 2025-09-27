@php
    $footerCaption = getContent('footer.content', true);
    $contactCaption = getContent('contact_us.content', true);
    $pages = App\Models\Page::activeTemplate()->where('is_default', Status::NO)->get();
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

<footer class="footer-area bg-img bg-overlay-one" style="background-image: url({{ frontendImage('footer', @$footerCaption->data_values->background_image, '1900x650') }});">
    <div class="footer-top py-50 container">
        <div class="row justify-content-center gy-5">
            <div class="col-xl-4 col-sm-6 pe-lg-5">
                <div class="footer-item">
                    <div class="footer-item__logo">
                        <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="{{ gs('site_name') }}"></a>
                    </div>
                    <p class="footer-item__desc">{{ __(@$footerCaption->data_values->short_details) }}</p>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6">
                <div class="footer-item">
                    <h5 class="footer-item__title"> @lang('Quick Links') </h5>
                    <ul class="footer-menu">
                        @foreach ($pages as $item)
                            <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('pages', ['slug' => $item->slug]) }}">{{ __($item->name) }}</a></li>
                        @endforeach

                        <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('plans') }}">@lang('Mining Plans')</a></li>
                        <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('blog') }}">@lang('Blog')</a></li>
                        <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('contact') }}">@lang('Contact')</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="footer-item">
                    <h5 class="footer-item__title">@lang('Useful Links')</h5>
                    <ul class="footer-menu">
                        @foreach ($policyPages as $page)
                            <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('policy.pages', $page->slug) }}">{{ __($page->data_values->title) }}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="footer-item">
                    <h5 class="footer-item__title">@lang('Contact Info') </h5>
                    <ul class="footer-contact-menu">
                        <li class="footer-contact-menu__item">
                            <div class="footer-contact-menu__item-icon">
                                <i class="las la-phone"></i>
                            </div>
                            <div class="footer-contact-menu__item-content">
                                <p><a href="tel:{{ @$contactCaption->data_values->contact_number }}">{{ @$contactCaption->data_values->contact_number }}</a></p>
                            </div>
                        </li>
                        <li class="footer-contact-menu__item">
                            <div class="footer-contact-menu__item-icon">
                                <i class="lar la-envelope"></i>
                            </div>
                            <div class="footer-contact-menu__item-content">
                                <p><a href="mailto:{{ @$contactCaption->data_values->email_address }}">{{ @$contactCaption->data_values->email_address }}</a></p>
                            </div>
                        </li>
                        <li class="footer-contact-menu__item">
                            <div class="footer-contact-menu__item-icon">
                                <i class="las la-map-marker-alt"></i>
                            </div>
                            <div class="footer-contact-menu__item-content">
                                <p>{{ @$contactCaption->data_values->contact_details }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer py-3">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-12 text-center">
                    <div class="bottom-footer-text text-white">@lang('Copyright') &copy; {{ date('Y') }} <a class="text--base" href="{{ route('home') }}">{{ gs('site_name') }}</a>. @lang('All rights reserved')</div>
                </div>
            </div>
        </div>
    </div>
</footer>
