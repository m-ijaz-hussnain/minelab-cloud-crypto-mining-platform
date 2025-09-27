<table class="table--responsive--lg table">
    <thead>
        <tr>
            <th>@lang('Trx')</th>
            <th>@lang('Transacted')</th>
            <th>@lang('Amount')</th>
            <th>@lang('Post Balance')</th>
            <th>@lang('Detail')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $trx)
            <tr>
                <td>
                    <small><strong>{{ $trx->trx }}</strong></small>
                </td>

                <td>
                    <small>{{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}</small>
                </td>

                <td class="budget">
                    <small class="fw-bold @if ($trx->trx_type == '+') text-success @else text-danger @endif">
                        {{ $trx->trx_type }} {{ showAmount($trx->amount, 8, exceptZeros: true, currencyFormat: false) }} {{ __(strtoupper($trx->currency)) }}
                    </small>
                </td>

                <td class="budget">
                    <small>
                        {{ showAmount($trx->post_balance, 8, exceptZeros: true, currencyFormat: false) }} {{ __(strtoupper($trx->currency)) }}
                    </small>
                </td>

                <td>
                    <small>{{ __($trx->details) }}</small>
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
