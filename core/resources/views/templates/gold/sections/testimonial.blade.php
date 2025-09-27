@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonials = getContent('testimonial.element', orderById: true);
@endphp
<section class="testimonials py-120 bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/thumbs/testimonial-bg.png') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading">
                    <h2 class="section-heading__title"> {{ __(@$testimonialContent->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$testimonialContent->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">
            @foreach ($testimonials as $testimonial)
                <div class="testimonails-card">
                    <div class="testimonial-item flex-wrap">
                        <div class="testimonial-item__thumb">
                            <img src="{{ frontendImage('testimonial' , @$testimonial->data_values->image) }}" class="fit-image" alt="@lang('image')">
                        </div>
                        <div class="testimonial-item__content">
                            <div class="testimonial-item__info">
                                <h5 class="testimonial-item__name"> {{ __($testimonial->data_values->author) }}</h5>
                                <span class="testimonial-item__designation fs-14"> {{ __($testimonial->data_values->designation) }}</span>
                            </div>
                            <p class="testimonial-item__desc">{{ __($testimonial->data_values->quote) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
