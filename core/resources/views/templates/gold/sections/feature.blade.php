@php
    $feature = getContent('feature.content', true);
    $elements = getContent('feature.element', false, 6, true);
    $elements = $elements->chunk(ceil($elements->count() / 2));
@endphp

<section class="feature-section py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading">
                    <h2 class="section-heading__title"> {{ __(@$feature->data_values->heading) }} </h2>
                    <p class="section-heading__desc">{{ __(@$feature->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 align-items-center">
            <div class="col-lg-5 col-sm-6">
                @foreach ($elements[0] ?? [] as $item)
                    <div class="feature-item flex-wrap">
                        <span class="feature-item__icon before-shadow flex-center">
                            @php
                                echo $item->data_values->icon;
                            @endphp
                        </span>
                        <div class="feature-item__content">
                            <h4 class="feature-item__title">{{ __($item->data_values->title) }}</h4>
                            <p class="feature-item__desc">{{ __($item->data_values->description) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-2 d-lg-block d-none">
                <div class="feature-thumb">
                    <img src="{{ frontendImage('feature' , @$feature->data_values->image, '500x430') }}" alt="@lang('image')">
                </div>
            </div>
            <div class="col-lg-5 col-sm-6">
                @foreach ($elements[1] ?? [] as $item)
                    <div class="feature-item flex-wrap style-right">
                        <span class="feature-item__icon before-shadow flex-center">
                            @php
                                echo $item->data_values->icon;
                            @endphp
                        </span>
                        <div class="feature-item__content">
                            <h4 class="feature-item__title">{{ __($item->data_values->title) }}</h4>
                            <p class="feature-item__desc">{{ __($item->data_values->description) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
