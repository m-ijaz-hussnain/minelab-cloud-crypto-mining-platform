@extends($activeTemplate . 'layouts.master')
@section('content')

    <div class="notice"></div>

    @if (gs('kv') && $user->kv != Status::KYC_VERIFIED)
        @php
            $kyc = getContent('kyc.content', true);
        @endphp
        <div class="row mb-5">
            <div class="col-12">
                @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                    <div class="alert alert-danger" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="alert-heading mb-0">@lang('KYC Documents Rejected')</h4>
                            <button class="btn btn--base pill btn--sm" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
                        </div>
                        <hr class="my-3">
                        <p class="mb-2">{{ __(@$kyc->data_values->reject) }} <a class="text-base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Re-submit Documents')</a>.</p>
                        <a class="text-base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                    </div>
                @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                        <hr>
                        <p class="mb-0">{{ __(@$kyc->data_values->required) }} <a class="text-base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a></p>
                    </div>
                @elseif(auth()->user()->kv == Status::KYC_PENDING)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                        <hr>
                        <p class="mb-0">{{ __(@$kyc->data_values->pending) }} <a class="text-base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="row gy-4 justify-content-center">
        <div class="col-lg-4 col-sm-6 col-xsm-6">
            <div class="dashboard-widget flex-align">
                <span class="dashboard-widget__icon flex-center before-shadow"><span class="icon-Money"></span></span>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Balance')</span>
                    <h4 class="dashboard-widget__title">{{ showAmount(auth()->user()->balance) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xsm-6">
            <div class="dashboard-widget flex-align">
                <span class="dashboard-widget__icon flex-center before-shadow"><span class="icon-Wallet_light"></span></span>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Referral Bonus')</span>
                    <h4 class="dashboard-widget__title">{{ showAmount($referralBonus) }}</h4>
                </div>
            </div>
        </div>
        @foreach ($miners as $item)
            <div class="col-lg-4 col-sm-6 col-xsm-6">
                <div class="dashboard-widget flex-align">
                    <span class="dashboard-widget__icon flex-center before-shadow">
                        <img alt="@lang('Image')" src="{{ getImage(getFilePath('miner') . '/' . $item->coin_image, getFileSize('miner')) }}">
                    </span>
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">{{ strtoupper($item->coin_code) }} @lang('Wallet')</span>
                        <h4 class="dashboard-widget__title">
                            {{ showAmount($item->userCoinBalances->balance, 8, exceptZeros: true, currencyFormat: false) }}
                            {{ strtoupper($item->coin_code) }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="dashboard__content pt-80">
        <h5>@lang('Latest Transactions')</h5>
        @include($activeTemplate . 'partials.transaction_table', ['transactions' => $transactions])
    </div>
@endsection
