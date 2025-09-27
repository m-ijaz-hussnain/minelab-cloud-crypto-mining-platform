@php
    $breadcrumb = getContent('breadcrumb.content', true);
@endphp

<section class="breadcrumb py-120 bg-img" data-background-image="{{ frontendImage('breadcrumb', @$breadcrumb->data_values->image, '1920x420') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title mb-0">{{ __($pageTitle) }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
