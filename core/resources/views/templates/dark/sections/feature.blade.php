@php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element', false, 6);
    $elements = $elements->chunk(ceil($elements->count() / 2));
@endphp

<section class="chooseus py-100 section-bg-two">
    <div class="container">
        <div class="row">
            <div class="section-heading">
                <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                <p class="section-heading__desc">{{ __(@$content->data_values->description) }}</p>
            </div>
        </div>
        <div class="row align-items-lg-center gy-4">
            <div class="col-xl-4 col-md-6">
                @foreach ($elements[0] ?? [] as $item)
                    <div class="chooseus-card style-two">
                        <span class="chooseus-card__icon">
                            @php echo $item->data_values->icon @endphp
                        </span>
                        <div class="chooseus-card__content">
                            <h5 class="chooseus-card__title">{{ __($item->data_values->title) }}</h5>
                            <p class="chooseus-card__desc">{{ __($item->data_values->description) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-xl-4 d-xl-block d-none px-5">
                <div class="chooseus-thumb">
                    <img src="{{ frontendImage('feature' , @$content->data_values->feature_image, '344x344') }}" alt="">
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                @foreach ($elements[1] ?? [] as $item)
                    <div class="chooseus-card">
                        <span class="chooseus-card__icon">
                            @php echo $item->data_values->icon @endphp
                        </span>
                        <div class="chooseus-card__content">
                            <h5 class="chooseus-card__title">{{ __($item->data_values->title) }}</h5>
                            <p class="chooseus-card__desc">{{ __($item->data_values->description) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
