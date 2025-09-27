@php
    $content = getContent('faq.content', true);
    $elements = getContent('faq.element', false, null, true);
    $elements = $elements->chunk(ceil($elements->count() / 2));
@endphp

<section class="faq-section ptb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-header">
                    <h2 class="title">{{ __(@$content->data_values->heading) }}</h2>
                    <span class="title-border"></span>
                    <p>{{ __(@$content->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gy-3">
            <div class="col-lg-6">
                <div class="faq-wrapper">

                    @foreach ($elements[0] as $item)
                        <div class="faq-item @if ($loop->first) active open @endif">
                            <h3 class="faq-title"><span class="title">{{ __($item->data_values->question) }}</span><span class="right-icon"></span></h3>
                            <div class="faq-content">
                                <p>{{ __($item->data_values->answer) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq-wrapper">
                    @foreach ($elements[1] as $item)
                        <div class="faq-item @if ($loop->first) active open @endif">
                            <h3 class="faq-title"><span class="title">{{ __($item->data_values->question) }}</span><span class="right-icon"></span></h3>
                            <div class="faq-content">
                                <p>{{ __($item->data_values->answer) }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
