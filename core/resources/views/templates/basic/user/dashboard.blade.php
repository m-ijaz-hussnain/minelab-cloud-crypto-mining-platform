@extends($activeTemplate . 'layouts.master')
@section('content')

    <div class="notice"></div>

    @if (gs('kv') && auth()->user()->kv != Status::KYC_VERIFIED)
        @php
            $kyc = getContent('kyc.content', true);
        @endphp
        <div class="row mrb-60">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                            <div class="alert alert-danger" role="alert">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="alert-heading mb-0">@lang('KYC Documents Rejected')</h4>
                                    <button class="btn btn--dark btn-sm" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
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
            </div>
        </div>
    @endif

    <div class="row justify-content-center ml-b-30">
        <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
            <div class="dash-item d-flex flex-wrap">
                <div class="dash-icon">
                    <i class="las la-money-bill fa-4x"></i>
                </div>
                <div class="dash-content">
                    <h3 class="sub-title">@lang('Balance')</h3>
                    <h4 class="title"> <span>{{ showAmount(auth()->user()->balance) }}</span></h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
            <div class="dash-item d-flex flex-wrap">
                <div class="dash-icon">
                    <i class="las la-wallet fa-4x"></i>
                </div>
                <div class="dash-content">
                    <h3 class="sub-title">@lang('Referral Bonus')</h3>
                    <h4 class="title"> <span>{{ showAmount($referralBonus) }}</span></h4>
                </div>
            </div>
        </div>
        @foreach ($miners as $item)
            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                <div class="dash-item d-flex flex-wrap">
                    <div class="dash-icon">
                        <img alt="@lang('Image')" src="{{ getImage(getFilePath('miner') . '/' . $item->coin_image, getFileSize('miner')) }}">
                    </div>
                    <div class="dash-content">
                        <h3 class="sub-title"><span>{{ strtoupper($item->coin_code) }}</span> @lang('Wallet')</h3>
                        <h4 class="title">{{ showAmount($item->userCoinBalances->balance, 8, exceptZeros: true, currencyFormat: false) }} {{ strtoupper($item->coin_code) }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <section class="mrt-30">
        <div class="order-section">
            <h2 class="section-title">@lang('Latest') <span>@lang('Transactions')</span></h2>
            <div class="order-table-area">
                @include($activeTemplate . 'partials.transaction_table', ['transactions' => $transactions])
            </div>
        </div>
    </section>

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
