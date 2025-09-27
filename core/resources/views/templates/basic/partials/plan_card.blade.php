@if ($miners?->count() > 1)
    <ul class="nav nav-tabs pricing-tab-menu">
        @foreach ($miners as $item)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active show @endif" data-bs-toggle="tab"
                    href="#active_tab{{ $loop->iteration }}">{{ $item->name }}</a>
            </li>
        @endforeach
    </ul>

@endif
<div class="tab-content">
    @foreach ($miners as $item)
        <div class="tab-pane fade @if ($loop->first) active show @endif"
            id="active_tab{{ $loop->iteration }}">
            <div class="row justify-content-center ml-b-30 mrt-20">
                @foreach ($item->activePlans as $plan)
                    <div class="col-lg-3 col-md-6 col-sm-6 mrb-60">
                        <div class="pricing-item text-center">
                            <div class="pricing-header">
                                <div class="pricing-icon">
                                    <i class="fas fa-smile"></i>
                                </div>
                                <h3 class="sub-title">{{ __($plan->title) }}</h3>
                                <span class="pricing-border"></span>
                                <h2 class="title"><span class="pricing-pre">
                                        {{ gs('cur_sym') }}</span>{{ showAmount($plan->price, currencyFormat: false) }}
                                    <span class="pricing-post">/
                                        {{ $plan->period . ' ' . $plan->periodUnitText }}</span>
                                </h2>
                            </div>
                            <div class="pricing-body">
                                <ul class="pricing-list">
                                    <li>
                                        @lang('Return per day:')
                                        {{ showAmount($plan->min_return_per_day, currencyFormat: false) }}
                                        {{ strtoupper($item->coin_code) }}
                                        @if ($plan->max_return_per_day)
                                            - {{ showAmount($plan->max_return_per_day, currencyFormat: false) }}
                                            {{ strtoupper($item->coin_code) }}
                                        @endif
                                    </li>
                                    <li>{{ getAmount($plan->maintenance_cost) }}% @lang('Maintenance Cost Per Day')</li>
                                    @foreach ($plan->features ?? [] as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                                <div class="pricing-btn-area">
                                    @guest
                                        <a class="cmn-btn-active" href="{{ route('user.login') }}">@lang('Buy Now')</a>
                                    @else
                                        <a class="cmn-btn-active buy-plan" data-id="{{ $plan->id }}"
                                            data-title="{{ $plan->title }}"
                                            data-price="{{ showAmount($plan->price, currencyFormat: false) }}"
                                            href="javascript:void(0)">@lang('Buy Now')</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@auth
    @include($activeTemplate . 'partials.buy_plan_modal')
@endauth
