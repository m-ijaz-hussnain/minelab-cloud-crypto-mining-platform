@php
    $breadcrumb = getContent('breadcrumb.content', true);
@endphp

<section class="breadcumb bg-overlay-one bg-img" style="background-image: url({{ frontendImage('breadcrumb', @$breadcrumb->data_values->breadcrumb_image, '2000x1200') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcumb__wrapper">
                    <h2 class="breadcumb__title">{{ __($pageTitle) }}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
