@php
    $content = getContent('testimonial.content', true);
    $testimonials = getContent('testimonial.element');
@endphp

<div class="client-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    <span class="title-border"></span>
                    <p>{{ __(@$content->data_values->description) }} </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="client-slider">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="client-item">
                                    <div class="client-thumb"> <img src="{{ frontendImage('testimonial', $testimonial->data_values->author_image, '128x128') }}" alt="@lang('client')">
                                    </div>
                                    <div class="client-content">
                                        <div class="client-icon"> <i class="icon-quote-left"></i> </div>
                                        <p>{{ __($testimonial->data_values->quote) }}</p>
                                    </div>
                                    <div class="client-footer">
                                        <h3 class="title">{{ __($testimonial->data_values->author) }}</h3> <span class="sub-title">{{ __($testimonial->data_values->designation) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        'use strict';
        (function($) {
            var swiper = new Swiper('.client-slider', {
                slidesPerView: 2,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    speed: 2000,
                    delay: 3000,
                },
                speed: 1000,
                breakpoints: {
                    991: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 1,
                    },
                    575: {
                        slidesPerView: 1,
                    },
                }
            });
        })(jQuery)
    </script>
@endpush
