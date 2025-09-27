@php
    $content = getContent('banner.content', true);
@endphp

<section class="banner bg-img bg-overlay-one" style="background-image: url({{ frontendImage('banner' , @$content->data_values->image, '1920x815') }});">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-7">
                <div class="banner-content">
                    <h1 class="banner-content__title">{{ __(@$content->data_values->heading) }}</h1>
                    <p class="banner-content__desc">{{ __(@$content->data_values->description) }}</p>
                    <a class="btn--base" href="{{ @$content->data_values->button_url }}">{{ __(@$content->data_values->button_text) }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
