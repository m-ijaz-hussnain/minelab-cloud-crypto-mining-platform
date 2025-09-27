@php
    $support = getContent('support_coin.content', true);
    $supportCoin = getContent('support_coin.element', orderById: true);
@endphp
<section class="support-coin py-120 section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading">
                    <h2 class="section-heading__title"> {{ __(@$support->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$support->data_values->description) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10">
                <div class="row gy-4 justify-content-center">
                    @foreach ($supportCoin as $coin)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xsm-6">
                            <div class="support-coin-item flex-align">
                                <span class="support-coin-item__icon">
                                    <img src="{{ frontendImage('support_coin' , @$coin->data_values->image, '50x50') }}" alt="@lang('image')">
                                </span>
                                <div class="support-coin-item__content">
                                    <h5 class="support-coin-item__title mb-0">{{ @$coin->data_values->title }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
