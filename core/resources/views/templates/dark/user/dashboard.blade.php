@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="notice"></div>
    @if (gs('kv') && auth()->user()->kv != Status::KYC_VERIFIED)
        @php
            $kyc = getContent('kyc.content', true);
        @endphp
        <div class="row mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                        <div class="alert alert-danger" role="alert">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="alert-heading mb-0">@lang('KYC Documents Rejected')</h4>
                                <button class="btn btn--danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
                            </div>
                            <hr class="my-3">
                            <p class="mb-2">{{ __(@$kyc->data_values->reject) }} <a class="text--base"
                                    href="{{ route('user.kyc.form') }}">@lang('Click Here to Re-submit Documents')</a>.</p>
                            <a class="text--base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                            <hr>
                            <p class="mb-0">{{ __(@$kyc->data_values->required) }} <a class="text--base"
                                    href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a></p>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_PENDING)
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                            <hr>
                            <p class="mb-0">{{ __(@$kyc->data_values->pending) }} <a class="text--base"
                                    href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                        </div>
                    @endif
                </div>
                </div>
            </div>
        </div>
    @endif

    <!-- dashboard-section start -->
    <div class="row gy-4 dashboard-card-wrapper">
        <div class="col-xl-6 col-sm-6">
            <div class="dashboard-card border-bottom-info">
                <div class="dashboard-card__thumb-title">
                    <div class="dashboard-card__thumb rounded-0 border-0">
                        <i class="las la-money-bill fa-4x"></i>
                    </div>
                    <h5 class="dashboard-card__title"> @lang('Balance')</h5>
                </div>
                <div class="dashboard-card__content">
                    <h4 class="dashboard-card__Status">{{ showAmount(auth()->user()->balance) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-sm-6">
            <div class="dashboard-card border-bottom-violet">
                <div class="dashboard-card__thumb-title">
                    <div class="dashboard-card__thumb rounded-0 border-0">
                        <i class="las la-wallet fa-4x"></i>
                    </div>
                    <h5 class="dashboard-card__title"> @lang('Referral Bonus')</h5>
                </div>
                <div class="dashboard-card__content">
                    <h4 class="dashboard-card__Status">{{ showAmount($referralBonus) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex mt-4 flex-wrap gap-3">
        @foreach ($miners as $item)
            <div class="dashboard-card border-bottom-violet">
                <div class="dashboard-card__thumb-title">
                    <div class="dashboard-card__thumb">
                        <img src="{{ getImage(getFilePath('miner') . '/' . $item->coin_image, getFileSize('miner')) }}"
                            alt="@lang('Image')">
                    </div>
                    <h5 class="dashboard-card__title"> <span>{{ strtoupper($item->coin_code) }}</span> @lang('Wallet')
                    </h5>
                </div>
                <div class="dashboard-card__content">
                    <h4 class="dashboard-card__Status">
                        {{ showAmount($item->userCoinBalances->balance, 8, exceptZeros: true, currencyFormat: false) }}
                        {{ strtoupper($item->coin_code) }}</h4>
                </div>
            </div>
        @endforeach
    </div>
    <!-- dashboard-section end -->

    <div class="pt-40">
        <h5>@lang('Latest Transactions')</h5>
        <div class="dashboard-table">
            @include($activeTemplate . 'partials.transaction_table', ['transactions' => $transactions])
        </div>
    </div>

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('style')
    <style>
        .custom--modal .btn-close {
            background-image: none !important;
            color: #fff !important;
            font-size: 20px
        }

        .custom--modal .btn-close:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
