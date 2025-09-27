@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Transaction Number')</th>

                                    @if (!request()->routeIs('admin.users.withdrawals'))
                                        <th>@lang('Username')</th>
                                    @endif

                                    <th>@lang('Wallet')</th>
                                    <th>@lang('Amount')</th>

                                    @if (request()->routeIs('admin.withdraw.data.all'))
                                        <th>@lang('Status')</th>
                                    @endif

                                    <th>@lang('Action')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $withdraw)
                                    <tr>
                                        <td>
                                            {{ showDateTime($withdraw->created_at) }}
                                        </td>
                                        <td class="fw-bold">
                                            {{ $withdraw->trx }}
                                        </td>

                                        @if (!request()->routeIs('admin.users.withdrawals'))
                                            <td>
                                                <a href="{{ route('admin.users.detail', $withdraw->user_id) }}">{{ @$withdraw->user->username }}</a>
                                            </td>
                                        @endif

                                        <td>
                                            <span class="fw-bold">{{ @$withdraw->userCoinBalance->wallet }}</span>
                                        </td>

                                        <td>
                                            <strong>{{ showAmount($withdraw->amount, 8, exceptZeros: true, currencyFormat: false) }} {{ __(strtoupper($withdraw->userCoinBalance->miner->coin_code)) }}</strong>

                                        </td>

                                        @if (request()->routeIs('admin.withdraw.data.all'))
                                            <td>
                                                @php echo $withdraw->statusBadge @endphp
                                            </td>
                                        @endif

                                        <td>
                                            <a href="{{ route('admin.withdraw.data.details', $withdraw->id) }}" class="btn btn-sm btn-outline--primary ms-1">
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($withdrawals->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($withdrawals) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-inline">
        <select name="currency" class="form-control onChangeSubmit" form="search-form">
            <option value="">@lang('All')</option>
            @foreach ($currencies as $item)
                <option value="{{ $item }}" @selected(request()->currency == $item)>{{ $item }}</option>
            @endforeach
        </select>
    </div>
    <x-search-form dateSearch='yes' placeholder='Username / TRX' />
@endpush
