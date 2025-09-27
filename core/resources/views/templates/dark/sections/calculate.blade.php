@php
    $content = getContent('calculate.content', true);
    $miners = App\Models\Miner::with('plans')
        ->whereHas('plans')
        ->orderBy('name', 'ASC')
        ->get();
@endphp
<section class="calculator section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="banner-calculator">
                    <form action="#">
                        <h3 class="banner-calculator__title">{{ __(@$content->data_values->heading) }}</h3>
                        <div class="row gy-3 align-items-center">
                            <div class="col-lg-4 col-sm-6">
                                <label class="text--base">@lang('Select Coin')</label>
                                <select class="custom--select bg--base-two w-100" name="miner">
                                    <option value="" disabled>@lang('Select Coin')</option>
                                    @foreach ($miners as $miner)
                                        <option data-coin_code="{{ strtoupper($miner->coin_code) }}" data-plans="{{ $miner->plans }}" value="{{ $miner->id }}" @selected($loop->first)>{{ __($miner->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label class="text--base">@lang('Select Plan')</label>
                                <select class="custom--select revenue-calculate plans bg--base-two w-100">
                                    <option value="" disabled>@lang('Select Plan')</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <div class="banner-calculator__content revenue-area">
                                    <span class="banner-calculator__text"> @lang('Estimated Revenue')</span>
                                    <h3 class="banner-calculator__number">0</h3>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        'use strict';

        (function($) {

            $('select[name="miner"]').on('change', function() {
                var plans = $(this).find(':selected').data('plans');
                var coin_code = $(this).find(':selected').data('coin_code');
                var output = `<select class="revenue-calculate"> <option value="" disabled>@lang('Select Plan')</option>`;

                if (plans.length != 0) {
                    $.each(plans, function(key, plan) {
                        var period = totalPeriodInDay(plan.period, plan.period_unit);
                        var per_day = 0;
                        if (plan.max_return_per_day) {
                            per_day = period * parseFloat(plan.min_return_per_day) + ' - ' + period * parseFloat(plan.max_return_per_day);
                        } else {
                            per_day = period * parseFloat(plan.min_return_per_day);
                        }

                        output += `<option value="${per_day} ${coin_code}"> ${plan.title} </option>`;
                    });

                    output += '</select>'

                    $('.plans').html(output);
                }

                $('.revenue-area .sub-title').hide('slow')
                $('.revenue-area .title').hide('slow')
                $('.revenue-calculate').change();
            }).change();

            let revenue = $('.revenue-calculate').find(":selected").val();
            if (revenue) {
                $('.revenue-area .banner-calculator__number').text(revenue).hide().show();
            }

            function totalPeriodInDay(time_limit, type) {
                if (type == 0)
                    return time_limit;

                else if (type == 1)
                    return time_limit * 30;

                else if (type == 2)
                    return time_limit * 365;

            }

            $(document).on('change', '.revenue-calculate', function() {
                $('.revenue-area .banner-calculator__text').text(`@lang('Estimated Revenue')`).hide().show();
                $('.revenue-area .banner-calculator__number').text($(this).val()).hide().show();
            });
        })(jQuery)
    </script>
@endpush
