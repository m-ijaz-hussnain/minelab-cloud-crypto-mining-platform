@php
    $content = getContent('about.content', true);
    $elements = getContent('about.element');
@endphp

<section class="about pt-100 pb-100 section-bg">
    <div class="container">
        <div class="row gy-4 flex-wrap-reverse">
            <div class="col-lg-6 pe-lg-5">
                <div class="about-thumb">
                    <img src="{{ frontendImage('about', @$content->data_values->image, '600x500') }}" alt="">
                    <div class="about-thumb__coin">
                        <img src="{{ frontendImage('about', @$content->data_values->coin_image, '100x115') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-heading style-two">
                    <h3 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h3>
                    <p class="section-heading__desc"> {{ __(@$content->data_values->description) }}</p>
                </div>
                <div class="about-item-wrapper">
                    @foreach ($elements as $item)
                        <div class="about-item">
                            <div class="about-item__icon">@php echo $item->data_values->icon @endphp</div>
                            <div class="about-item__content">
                                <h5 class="about-item__title">{{ __($item->data_values->title) }}</h5>
                                <p class="about-item__desc">{{ __($item->data_values->description) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
