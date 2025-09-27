@php
    $footer = getContent('footer.content', true);
    $contact = getContent('contact_us.content', true);
    $pages = App\Models\Page::activeTemplate()->where('is_default', Status::NO)->get();
    $policyPages = getContent('policy_pages.element', false, null, true);
    $socials = getContent('social_icon.element');
@endphp

<footer class="footer-section ptb-80">
    <div class="container">
        <div class="footer-area">
            <div class="row ml-b-30">
                <div class="col-lg-4 col-sm-6 mrb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">{{ __(gs('site_name')) }}</h3>
                        <p>{{ __(@$footer->data_values->short_details) }}</p>

                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mrb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Quick Links')</h3>
                        <ul class="footer-list">
                            @foreach ($pages as $item)
                                <li><a href="{{ route('pages', ['slug' => $item->slug]) }}">@lang($item->name)</a></li>
                            @endforeach
                            <li><a href="{{ route('plans') }}">@lang('Mining Plans')</a></li>
                            <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
                            <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 mrb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Useful Links')</h3>
                        <ul class="footer-list">
                            @foreach ($policyPages as $item)
                                <li><a href="{{ route('policy.pages', $item->slug) }}">{{ __($item->data_values->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mrb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">@lang('Contact Info')</h3>
                        <ul class="footer-list">
                            <li>@lang('Call Us Now') <a href="tel:{{ @$contact->data_values->contact_number }}">{{ @$contact->data_values->contact_number }}</a></li>
                            <li><a href="mailto:{{ @$contact->data_values->email_address }}">{{ @$contact->data_values->email_address }}</a></li>
                            <li>{{ @$contact->data_values->contact_details }}</li>
                        </ul>
                    </div>
                </div>
                @if ($socials->count() > 0)
                    <div class="col-lg-12">
                        <div class="social-area d-flex justify-content-center">
                            <ul class="footer-social">
                                @foreach ($socials as $item)
                                    <li><a href="{{ $item->data_values->url }}" target="_blank">@php echo $item->data_values->social_icon @endphp</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>
<div class="privacy-area privacy-area--style">
    <div class="container">
        <div class="copyright-area d-flex align-items-center justify-content-center flex-wrap">
            <div class="copyright">
                <p class="text-center">@lang('Copyright') &copy; {{ date('Y') }} <a href="{{ route('home') }}" class="text-base">{{ gs('site_name') }}</a>. @lang('All rights reserved')</p>
            </div>
        </div>
    </div>
</div>
