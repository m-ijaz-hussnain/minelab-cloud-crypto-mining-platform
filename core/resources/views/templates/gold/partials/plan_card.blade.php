@php
    if (!@$class) {
        $class = 'col-xl-3 col-md-6 col-sm-8';
    }
@endphp

<div class="pricing-tab">
    @if ($miners?->count() > 1)
        <ul class="custom--tab nav nav-pills" id="pills-tab" role="tablist">
            @foreach ($miners as $item)
                <li class="nav-item" role="presentation">
                    <button class="nav-link fs-16 @if ($loop->first) active @endif" id="pills-{{ $loop->iteration }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $loop->iteration }}" type="button" role="tab" aria-controls="pills-{{ $loop->iteration }}" aria-selected="@if ($loop->first) true @else false @endif"><span class="text">{{ $item->name }}</span></button>
                </li>
            @endforeach
        </ul>
    @endif
    <div class="tab-content" id="pills-tabContent">
        @foreach ($miners as $item)
            <div class="tab-pane fade @if ($loop->first) show active @endif" id="pills-{{ $loop->iteration }}" role="tabpanel" aria-labelledby="pills-{{ $loop->iteration }}-tab" tabindex="0">
                <div class="row gy-4 justify-content-center">
                    @foreach ($item->activePlans as $plan)
                        <div class="{{ $class }}">
                            <div class="pricing-item">
                                <div class="pricing-item__content">
                                    <div class="pricing-item__thumb">
                                        <img src="{{ getImage(getFilePath('miner') . '/' . @$item->coin_image, getFileSize('miner')) }}" alt="@lang('image')">
                                    </div>
                                    <div class="pricing-item__header">
                                        <h5 class="pricing-item__title">{{ __($plan->title) }}</h5>
                                        <h3 class="pricing-item__price mb-0"> <span class="text--gradient d-flex align-items-start"> <small class="dollar">{{ gs('cur_sym') }}</small><span class="price">{{ showAmount($plan->price, currencyFormat: false) }}</span> </span> <small class="text">
                                                /{{ $plan->period . ' ' . $plan->periodUnitText }}</small> </h3>
                                    </div>
                                    <div class="pricing-item__body">
                                        <ul class="text-list">

                                            <li class="text-list__item fs-18">@lang('Return per day:')
                                                {{ showAmount($plan->min_return_per_day, currencyFormat: false) }} {{ strtoupper($item->coin_code) }}
                                                @if ($plan->max_return_per_day)
                                                    - {{ showAmount($plan->max_return_per_day, currencyFormat: false) }} {{ strtoupper($item->coin_code) }}
                                                @endif
                                            </li>

                                            <li class="text-list__item fs-18">{{ getAmount($plan->maintenance_cost) }}% @lang('Maintenance cost per day')</li>
                                            @foreach ($plan->features ?? [] as $feature)
                                                <li class="text-list__item fs-18">{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="pricing-item__footer">
                                    @guest
                                        <a class="btn btn-outline--base btn--md" href="{{ route('user.login') }}">@lang('Buy Now')</a>
                                    @else
                                        <button class="btn btn-outline--base btn--md pill buy-plan" data-id="{{ $plan->id }}" data-title="{{ $plan->title }}" data-price="{{ showAmount($plan->price, currencyFormat: false) }}" type="button">@lang('Buy Now')</button>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@auth
    @include($activeTemplate . 'partials.buy_plan_modal')
@endauth
