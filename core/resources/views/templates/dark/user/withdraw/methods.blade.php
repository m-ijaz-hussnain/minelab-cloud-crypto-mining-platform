@extends($activeTemplate . 'layouts.master')

@section('content')
    @if ($withdrawMethod->count())
        <div class="wallet-card-wrapper">
            @foreach ($withdrawMethod as $data)
                <div class="wallet-card">
                    <div class="wallet-card-body">

                        <div class="top flex-wrap">
                            <img alt="Image" class="logo" src="{{ getImage(getFilePath('miner') . '/' . $data->miner->coin_image, getFileSize('miner')) }}">
                            <div>
                                <h5 class="title">{{ strtoupper($data->miner->coin_code) }} @lang('Wallet')</h5>
                                <small>{{ showAmount($data->balance, 8, exceptZeros: true, currencyFormat:false) }}</strong> {{ strtoupper($data->miner->coin_code) }}</small>
                            </div>

                            <div class="ms-sm-auto">
                                <button class="btn btn--sm btn--base withdrawBtn withdraw-btn" data-coin_code="{{ __(strtoupper($data->miner->coin_code)) }}" data-id="{{ $data->id }}" data-resource="{{ $data }}" data-wallet_address="{{ $data->wallet }}" type="button">
                                    @lang('Withdraw Now')
                                </button>
                            </div>
                        </div>

                        <p class="address">
                            <span class="label">@lang('Wallet Address')</span>
                            <span class="value">
                                @if ($data->wallet)
                                    {{ $data->wallet }}
                                @else
                                    @lang('No wallet address provided yet'),
                                    <a class="text--base" href="{{ route('user.wallets') }}?coin_code={{ strtoupper($data->miner->coin_code) }}">
                                        @lang('Update now')
                                    </a>
                                @endif
                            </span>
                        </p>

                        <p class="address mt-3">
                            <span class="label">@lang('Min Withdrawal Limit')</span>
                            <span class="value">
                                {{ showAmount($data->miner->min_withdraw_limit, 8, exceptZeros: true, currencyFormat:false) . ' ' . strtoupper($data->miner->coin_code) }}
                            </span>
                        </p>

                        <p class="address mt-3">
                            <span class="label">@lang('Max Withdrawal Limit')</span>
                            <span class="value">
                                {{ showAmount($data->miner->max_withdraw_limit, 8, exceptZeros: true, currencyFormat:false) . ' ' . strtoupper($data->miner->coin_code) }}
                            </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card custom--card">
            <div class="card-body">
                <h4 class="mb-0 text-center text--danger">@lang('You did\'t have any wallet yet')</h4>
            </div>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal custom--modal fade" id="withdrawModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="exampleModalLabel">@lang('Withdraw')</h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.withdraw.money') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="id" type="hidden" value="">
                            </div>
                        </div>
                        <div class="col-12">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input class="form-control form--control" id="amount" name="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" required="" type="text" value="{{ old('amount') }}">

                                <span class="input-group-text currency-addon"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .custom--modal .modal-content {
            text-align: left !important;
        }
    </style>
@endpush
@push('script')
    <script>
        'use strict';
        (function($) {
            $('.withdrawBtn').on('click', function() {
                let walletAddress = $(this).data('wallet_address');
                if (!walletAddress) {
                    notify('error', 'Please update your wallet address');
                    return;
                }
                var modal = $('#withdrawModal');
                modal.find('.currency-addon').text($(this).data('coin_code'));
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

        })(jQuery)
    </script>
@endpush
