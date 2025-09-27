@php
    $content = getContent('banner.content', true);
@endphp
<section class="banner-section bg-overlay-primary bg_img" data-background="{{ frontendImage('banner' , @$content->data_values->image, '1920x815') }}">
    <div class="container">
        <div class="row justify-content-center align-items-center ml-b-30">
            <div class="col-lg-10 mrb-30 text-center">
                <div class="banner-content">
                    <h2 class="title">{{ __(@$content->data_values->heading) }}</h2>
                    <p>{{ __(@$content->data_values->description) }}</p>
                    <div class="banner-btn justify-content-center">
                        <a class="cmn-btn py-3 px-5" href="{{ @$content->data_values->button_url }}">{{ __(@$content->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>
</section>
