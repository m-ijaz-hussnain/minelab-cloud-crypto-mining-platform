@php
    $aboutContent = getContent('about.content', true);
    $aboutElement = getContent('about.element', orderById: true);
@endphp

<section class="about py-120 section-bg">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-heading style-left">
                        <h2 class="section-heading__title">{{ __(@$aboutContent->data_values->heading) }}</h2>
                        <p class="section-heading__desc">{{ __(@$aboutContent->data_values->description) }}</p>
                    </div>
                    <div class="about-item-wrapper">
                        @foreach ($aboutElement as $about)
                            <div class="about-item flex-align">
                                <span class="about-item__icon flex-center">
                                    @php
                                        echo $about->data_values->icon;
                                    @endphp
                                </span>
                                <div class="about-item__content">
                                    <h5 class="about-item__title">{{ __(@$about->data_values->title) }}</h5>
                                    <p class="about-item__desc">{{ __(@$about->data_values->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content__thumb text-lg-end">
                    <img src="{{ frontendImage('about' , @$aboutContent->data_values->image, '570x620') }}" alt="@lang('image')">
                </div>
            </div>
        </div>
    </div>
</section>
