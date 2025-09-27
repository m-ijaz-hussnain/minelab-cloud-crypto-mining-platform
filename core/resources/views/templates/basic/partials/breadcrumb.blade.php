@php
    $breadcrumb = getContent('breadcrumb.content', true);
@endphp

<section class="banner-section inner-banner-section bg-overlay-primary bg_img" data-background="{{ frontendImage('breadcrumb', @$breadcrumb->data_values->breadcrumb_image, '1950x600') }}">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10 text-center">
                <div class="banner-content">
                    <h2 class="title mb-0">{{ __($pageTitle) }}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
