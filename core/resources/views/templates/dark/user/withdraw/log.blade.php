@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <form action="">
            <div class="input-group">
                <input class="form-control form--control" name="search" type="text" value="{{ request()->search }}" placeholder="@lang('Transaction ID / wallet')">
                <button class="input-group-text append-icon--btn">
                    <i class="las la-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="dashboard-table">
        <table class="table--responsive--lg table">
            <thead>
                <tr>
                    <th>@lang('Time')</th>
                    <th>@lang('Transaction ID')</th>
                    <th>@lang('Wallet')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdraws as $withdrawal)
                    <tr>
                        <td>
                            {{ showDateTime($withdrawal->created_at) }}
                        </td>
                        <td>{{ $withdrawal->trx }}</td>
                        <td>
                            <span title="{{ $withdrawal->userCoinBalance->wallet }}">{{ shortAddress($withdrawal->userCoinBalance->wallet) }}</span>
                        </td>
                        <td>
                            <strong>{{ showAmount($withdrawal->amount, 8, exceptZeros:true, currencyFormat:false) }} {{ strtoupper($withdrawal->userCoinBalance->miner->coin_code) }}</strong>
                        </td>

                        <td>
                            @php
                                echo $withdrawal->statusBadge;
                            @endphp
                        </td>

                        <td>
                            @if ($withdrawal->status == Status::PAYMENT_SUCCESS)
                                <button class="btn btn--success detailBtn btn--xsm" data-admin_feedback="{{ $withdrawal->admin_feedback }}"><i class="las la-desktop"></i></button>
                            @elseif($withdrawal->status == Status::PAYMENT_REJECT)
                                <button class="btn btn--danger detailBtn btn--xsm" data-admin_feedback="{{ $withdrawal->admin_feedback }}"><i class="las la-desktop"></i></button>
                            @else
                                <a class="btn btn--warning btn--xsm" href="{{ route('user.withdraw.preview', encrypt($withdrawal->id)) }}"><i class="las la-desktop"></i></a>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ paginateLinks($withdraws) }}
    </div>

    <div class="modal custom--modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($) {

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');

                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
