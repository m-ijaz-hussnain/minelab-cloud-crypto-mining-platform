@php
    $transactionContent = getContent('transaction.content', true);
    $deposits = App\Models\Deposit::where('status', Status::PAYMENT_SUCCESS)
        ->with('user')
        ->orderBy('id', 'DESC')
        ->take(5)
        ->get();
    $withdraws = App\Models\Withdrawal::whereIn('status', [Status::PAYMENT_SUCCESS, Status::PAYMENT_PENDING])
        ->with('user', 'userCoinBalance.miner')
        ->orderBy('id', 'DESC')
        ->take(5)
        ->get();
@endphp

<section class="transaction py-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6">
                <h4 class="transaction__title mb-md-4 mb-3 text-center">{{ __(@$transactionContent->data_values->heading_one) }}</h4>
                <div class="transaction__content overflow-x-auto">
                    <table class="style-two scroll-table table">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Time')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deposits as $deposit)
                                <tr>
                                    <td>
                                        <strong>{{ @$deposit->user->fullname }} </strong>
                                    </td>
                                    <td>{{ showAmount($deposit->amount) }}</td>
                                    <td>{{ diffForHumans($deposit->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <h4 class="transaction__title mb-md-4 mb-3 text-center">{{ __(@$transactionContent->data_values->heading_two) }}</h4>
                <div class="transaction__content overflow-x-auto">
                    <table class="style-two scroll-table table">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Time')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdraws as $withdraw)
                                <tr>
                                    <td>
                                        <strong>{{ $withdraw->user->fullname }}</strong>
                                    </td>
                                    <td>{{ showAmount($withdraw->amount, 8, exceptZeros: true, currencyFormat:false) }} {{ strtoupper(@$withdraw->userCoinBalance->miner->coin_code) }}</td>
                                    <td>{{ diffForHumans($withdraw->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
