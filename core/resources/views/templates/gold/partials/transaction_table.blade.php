<table class="table--responsive--md table">
    <thead>
        <tr>
            <th>@lang('Transaction No.')</th>
            <th>@lang('Transacted')</th>
            <th>@lang('Amount')</th>
            <th>@lang('Post Balance')</th>
            <th>@lang('Detail')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $trx)
            <tr>
                <td><strong>{{ $trx->trx }}</strong></td>
                <td>{{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}</td>
                <td class="budget">
                    <span class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                        {{ $trx->trx_type }} {{ showAmount($trx->amount, 8, exceptZeros: true, currencyFormat:false) }} {{ strtoupper($trx->currency) }}
                    </span>
                </td>
                <td class="budget">
                    {{ showAmount($trx->post_balance, 8, exceptZeros: true, currencyFormat:false) }} {{ __(strtoupper($trx->currency)) }}
                </td>
                <td>{{ __($trx->details) }}</td>
            </tr>
        @empty
            <tr>
                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
