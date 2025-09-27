@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        @foreach ($badges as $badge)
            @php
                $userBadge = $userBadges->where('badge_id', $badge->id)->first() ?? false;
                $currentBadge = $userBadge ? $userBadge : $badge;
            @endphp
            <div class="col-sm-6 col-xl-4">
                <div class="achievement {{ $userBadge ? 'completed' : 'locked' }}">
                    <div class="image icon">
                        <img src="{{ getImage(getFilePath('badge') . '/' . $badge->image, getFileSize('badge')) }}" alt="{{ __($badge->name) }}">
                    </div>

                    <h3 class="mb-2">{{ __($badge->name) }}</h3>
                    <h6 class="mb-3">@lang('Min earning'): {{ showAmount($currentBadge->earning_amount) }}</h6>

                    @if ($userBadge)
                        <span class="achivement__ribbon success">@lang('Unlocked')</span>
                    @endif

                    <ul class="badge-benefits">
                        <li>@lang('Maintenance Discount'):
                            {{ getBadgeAmount($currentBadge->discount_maintenance_cost) }}
                        </li>
                        <li>@lang('Plan Purchase Discount'):
                            {{ getBadgeAmount($currentBadge->plan_price_discount) }}
                        </li>
                        <li>@lang('Increase Earning Boost'):
                            {{ getBadgeAmount($currentBadge->earning_boost) }}
                        </li>
                        <li>@lang('Enhance Referral Bonus'):
                            {{ getBadgeAmount($currentBadge->referral_bonus_boost) }}
                        </li>
                    </ul>

                </div>
            </div>
        @endforeach
    </div>
@endsection


@push('style')
    <style>
        .achievements {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .achievement {
            background: #e0e0e0;
            padding: 24px 32px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }

        .completed {
            background: #d4edda1a;
        }

        .in-progress {
            background: #d1ecf175;
        }

        .achievement.locked {
            background-color: #d4edda1a;
            position: relative;
            cursor: pointer;
        }

        .achievement.locked::after {
            content: '\f023';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            width: 100%;
            height: 100%;
            position: absolute;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(1px);
            border-radius: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #fff;
        }

        .achievement.locked:hover {
            border: transparent;
        }

        .achievement.locked:hover::after {
            content: '';
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(0.1px);
        }

        .icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 10px auto;
        }

        .bronze {
            background: #cd7f32;
        }

        .gold {
            background: #ffd700;
        }

        .purple {
            background: #6a0dad;
        }

        .silver {
            background: #c0c0c0;
        }

        .progress {
            height: 10px;
            background: #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress span {
            display: block;
            height: 100%;
            background: #28a745;
        }

        .badge-benefits {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }

        .badge-benefits li {
            display: flex;
            align-items: center;
            text-align: left;
            gap: 4px;
            line-height: 150%;

        }

        .badge-benefits li:not(:last-child) {
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 16px;
        }

        .badge-benefits li::before {
            content: '';
            width: 0.5em;
            height: 0.5em;
            border-radius: 50%;
            display: none;
            background-color: #4CAF50;
        }

        .achivement__ribbon {
            position: absolute;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
            height: 20px;
            top: 10px;
            right: -10px;
            padding: 0px 12px;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 30px;
            border-bottom-right-radius: 0;
            z-index: 1;
        }

        .achivement__ribbon::before {
            content: "";
            position: absolute;
            width: 10px;
            height: 20px;
            top: 100%;
            right: 0;
            z-index: 2;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .achivement__ribbon::after {
            content: "";
            position: absolute;
            width: 10px;
            height: 10px;
            top: 100%;
            right: 0;
            z-index: 1;
        }

        .achivement__ribbon.success {
            color: #fff;
            background-color: #22c55e;
        }

        .achivement__ribbon.success::before {
            background-color: #15803d;
        }

        .achivement__ribbon.success::after {
            background-color: #22c55e;
        }

        .achivement__ribbon.danger {
            color: #fff;
            background-color: #dc3545;
        }

        .achivement__ribbon.danger::before {
            background-color: #b7192c;
        }

        .achivement__ribbon.danger::after {
            background-color: #dc3545;
        }
    </style>
@endpush
