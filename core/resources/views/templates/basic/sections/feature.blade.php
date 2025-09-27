@php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element');
    $elements = $elements->chunk(ceil($elements->count() / 2));
@endphp

<section class="choose-section ptb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                    <span class="title-border"></span>
                    <p>{{ __(@$content->data_values->description) }}</p>
                </div>
            </div>
        </div>

        <div class="choose-item-area">
            <div class="row justify-content-between ml-b-60">
                <div class="col-lg-4 col-md-6 col-sm-8">

                    @foreach ($elements[0] as $item)
                        <div class="choose-item d-flex align-items-center mrb-60 flex-wrap">
                            <div class="choose-icon">
                                @php echo $item->data_values->icon @endphp
                            </div>
                            <div class="choose-content">
                                <h3 class="title">{{ __($item->data_values->title) }}</h3>
                                <p>{{ __($item->data_values->description) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8 choose-thumb-inner">
                    <div class="choose-thumb">
                        <img src="{{ frontendImage('feature', @$content->data_values->feature_image, '375x375') }}" alt="feature">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8">
                    @foreach ($elements[1] as $item)
                        <div class="choose-item d-flex align-items-center mrb-60 flex-wrap">
                            <div class="choose-icon">
                                @php echo $item->data_values->icon @endphp
                            </div>
                            <div class="choose-content">
                                <h3 class="title">{{ __($item->data_values->title) }}</h3>
                                <p>{{ __($item->data_values->description) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
