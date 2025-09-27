@php
    $banner = getContent('banner.content', true);
@endphp
<section class="banner-section">
    <div class="container">
        <div class="row gy-sm-5 gy-4 align-items-center">
            <div class="col-lg-5">
                <div class="banner-content">
                    <h1 class="banner-content__title">{{ __(@$banner->data_values->heading) }}</h1>
                    <p class="banner-content__desc">{{ __(@$banner->data_values->description) }}</p>
                    <div class="banner-content__button d-flex align-items-center gap-3">
                        <a href="{{ @$banner->data_values->button_url }}" class="btn btn--base pill">{{ __(@$banner->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5">
                <div class="banner-thumb text-center ps-lg-4">
                    <img src="{{ frontendImage('banner' , @$banner->data_values->image, '700x530') }}" alt="@lang('image')">
                </div>
            </div>
        </div>
    </div>
</section>
