@php
    $content = getContent('faq.content', true);
    $elements = getContent('faq.element', false, null, true);
    $elements = $elements->chunk(ceil($elements->count() / 2));
@endphp

<section class="faq py-100 section-bg">
    <div class="container">
        <div class="row">
            <div class="section-heading">
                <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                <p class="section-heading__desc">{{ __(@$content->data_values->description) }}</p>
            </div>
        </div>
        <div class="row gy-3">
            <div class="col-lg-6 pe-lg-5">
                <div class="accordion custom--accordion" id="accordionExample">

                    @foreach (@$elements[0] ?? [] as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="leftHeading{{ $item->id }}">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#leftCollapse{{ $item->id }}" type="button" aria-expanded="false" aria-controls="leftCollapse{{ $item->id }}">
                                    {{ __($item->data_values->question) }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="leftCollapse{{ $item->id }}" data-bs-parent="#accordionExample" aria-labelledby="leftHeading{{ $item->id }}">
                                <div class="accordion-body">
                                    <p class="accordion-body__desc">
                                        {{ __($item->data_values->answer) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="accordion custom--accordion" id="accordionExample2">
                    @foreach (@$elements[1] ?? [] as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="rightHeading{{ $item->id }}">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#rightCollapse{{ $item->id }}" type="button" aria-expanded="false" aria-controls="rightCollapse{{ $item->id }}">
                                    {{ __($item->data_values->question) }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="rightCollapse{{ $item->id }}" data-bs-parent="#accordionExample2" aria-labelledby="rightHeading{{ $item->id }}">
                                <div class="accordion-body">
                                    <p class="accordion-body__desc">
                                        {{ __($item->data_values->answer) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
