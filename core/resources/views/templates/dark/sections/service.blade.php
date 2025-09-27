@php
    $content = getContent('service.content', true);
    $elements = getContent('service.element');
@endphp

<section class="services py-100">
    <div class="container">
        <div class="row">
            <div class="section-heading">
                <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                <p class="section-heading__desc">{{ __(@$content->data_values->description) }}</p>
            </div>
        </div>
        <div class="row gy-4">
            @foreach ($elements as $item)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="service-card">
                        <div class="service-card__icon"> @php echo $item->data_values->icon @endphp </div>
                        <div class="service-card__content">
                            <h4 class="service-card__title">{{ __($item->data_values->title) }}</h4>
                            <p class="service-card__desc">{{ __($item->data_values->description) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
