@php
    $cta = getContent('cta.content', true);
@endphp
<section class="cta py-60 section-bg">
    <div class="container">
        <div class="cta-content flex-between gap-3">
            <div class="cta-content__left">
                <h2 class="cta-content__title mb-md-3 mb-2">{{ __(@$cta->data_values->heading) }}</h2>
                <p class="cta-content__desc">{{ __(@$cta->data_values->description) }}</p>
            </div>
            <div class="cta-content__right">
                <a href="{{ @$cta->data_values->button_url }}" class="btn btn--base pill">{{ __(@$cta->data_values->button_text) }}</a>
            </div>
        </div>
    </div>
</section>
