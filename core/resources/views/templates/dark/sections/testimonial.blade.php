@php
    $content = getContent('testimonial.content', true);
    $testimonials = getContent('testimonial.element');
@endphp

<section class="testimonails py-100 section-bg">
    <div class="container">
        <div class="row">
            <div class="section-heading">
                <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                <p class="section-heading__desc">{{ __(@$content->data_values->heading) }}</p>
            </div>
        </div>
        <div class="row gy-4 testimonails-item-wrapper">
            @foreach ($testimonials as $testimonial)
                <div class="col-lg-4">
                    <div class="testimonails-item">
                        <div class="testimonails-item__content">
                            <div class="testimonails-item__icon"><i class="fas fa-quote-left"></i></div>
                            <p class="testimonails-item__desc">{{ __($testimonial->data_values->quote) }}</p>
                        </div>
                        <div class="testimonails-item__info">
                            <div class="testimonails-item__thumb">
                                <img src="{{ frontendImage('testimonial', $testimonial->data_values->author_image, '128x128') }}" alt="@lang('Client')">
                            </div>
                            <h6 class="testimonails-item__name">{{ __($testimonial->data_values->author) }}</h6>
                            <span class="testimonails-item__designation"> {{ __($testimonial->data_values->designation) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
