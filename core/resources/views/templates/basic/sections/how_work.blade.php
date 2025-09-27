@php
    $content = getContent('how_work.content', true);
    $elements = getContent('how_work.element', false, null, true);
    $elements = $elements->chunk(ceil($elements->count() / 2));
@endphp

<section class="work-section ptb-120">
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
        <div class="row work-content-area justify-content-center ml-b-30">

            <div class="col-md-6 mrb-30">
                <div class="work-content">
                    <div class="work-item-area ml-b-30">
                        @foreach ($elements[0] as $item)
                            <div class="work-item d-flex mrb-30 flex-row-reverse flex-wrap">
                                <div class="work-icon">
                                    {{ __($loop->iteration) }}
                                    @php echo $item->data_values->icon @endphp
                                </div>
                                <div class="work-details work-details--style">
                                    <h3 class="title">{{ __($item->data_values->title) }}</h3>
                                    <p>{{ __($item->data_values->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6 mrb-30">
                <div class="work-content work-content--style">
                    <div class="work-item-area work-item-area-two ml-b-30">
                        @foreach ($elements[1] as $item)
                            <div class="work-item d-flex mrb-30 flex-wrap">
                                <div class="work-icon">
                                    {{ __($loop->iteration + 2) }}
                                    @php echo $item->data_values->icon @endphp
                                </div>
                                <div class="work-details work-details--style">
                                    <h3 class="title">{{ __($item->data_values->title) }}</h3>
                                    <p>{{ __($item->data_values->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
