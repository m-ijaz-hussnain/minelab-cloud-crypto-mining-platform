@php
    $content = getContent('service.content', true);
    $elements = getContent('service.element');
@endphp

<section class="service-section ptb-120">
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
        <div class="row justify-content-center ml-b-30">
            @foreach ($elements as $item)
                <div class="col-lg-4 col-md-6 col-sm-6 mrb-30">
                    <div class="service-item text-center">
                        <div class="service-icon">
                            @php echo $item->data_values->icon @endphp
                        </div>
                        <div class="service-content">
                            <h3 class="title">{{ __($item->data_values->title) }}</h3>
                            <p>{{ __($item->data_values->description) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
