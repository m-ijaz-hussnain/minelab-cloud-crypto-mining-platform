@php
    $content = getContent('calculate.content', true);
    $miners = App\Models\Miner::with('plans')
        ->whereHas('plans')
        ->orderBy('name', 'ASC')
        ->get();
@endphp

<section class="calculate-section">
    <div class="container">
        <div class="row justify-content-center ml-t-10 ml-b-40">
            <div class="col-lg-12 mrb-30">
                <div class="cal-area text-center">
                    <div class="cal-area-inner">
                        <div class="cal-title">
                            <h3 class="title">{{ __(@$content->data_values->heading) }}</h3>
                        </div>
                        <form class="cal-form mx-3">
                            <div class="cal-wrapper d-flex align-items-center justify-content-center flex-wrap">
                                <div class="cal-select form-group">
                                    <select class="nic-select" name="miner">
                                        <option value="" selected disabled>@lang('Select Coin')</option>
                                        @foreach ($miners as $miner)
                                            <option data-coin_code="{{ strtoupper($miner->coin_code) }}" data-plans="{{ $miner->plans }}" value="{{ $miner->id }}">{{ __($miner->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="cal-select plans form-group">
                                    <select class="revenue-calculate nic-select">
                                        <option value="" selected disabled>@lang('Select Plan')</option>
                                    </select>
                                </div>
                                <div class="revenue-area">
                                    <span class="sub-title"></span>
                                    <h3 class="title"></h3>
                                </div>
                            </div>
                        </form>
                    </div>
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
                var output = `<select class="revenue-calculate"> <option value="" selected disabled>@lang('Select Plan')</option>`;

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

                $('select').niceSelect();
                $('.revenue-area .sub-title').hide('slow')
                $('.revenue-area .title').hide('slow')

            });

            function totalPeriodInDay(time_limit, type) {
                if (type == 0)
                    return time_limit;

                else if (type == 1)
                    return time_limit * 30;

                else if (type == 2)
                    return time_limit * 365;

            }



            $(document).on('change', '.revenue-calculate', function() {
                $('.revenue-area .sub-title').text(`@lang('Estimated Revenue')`).hide().show('slow');
                $('.revenue-area .title').text($(this).val()).hide().show('slow');
            })
        })(jQuery)
    </script>
@endpush
