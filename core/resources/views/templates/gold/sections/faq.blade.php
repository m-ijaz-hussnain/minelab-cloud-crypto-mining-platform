@php
    $faqContent = getContent('faq.content', true);
    $faqs = getContent('faq.element', orderById: true);
@endphp
<section class="faq py-120 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-lg-block d-none">
                <div class="faq-thumb">
                    <img src="{{ frontendImage('faq' , @$faqContent->data_values->image, '625x545') }}" alt="@lang('image')">
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <div class="faq-content">
                    <div class="section-heading style-left">
                        <h2 class="section-heading__title">{{ __(@$faqContent->data_values->heading) }}</h2>
                        <p class="section-heading__desc">{{ __(@$faqContent->data_values->description) }}</p>
                    </div>
                    <div class="accordion custom--accordion" id="accordionExample">
                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="heading{{ $key }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="@if ($loop->first) true @endif" aria-controls="collapse{{ $key }}"> <span
                                            class="text">{{ __(@$faq->data_values->question) }}</span> </button>
                                </h5>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse @if ($loop->first) show @endif" aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="accordion-body__desc fs-18">{{ __(@$faq->data_values->answer) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
