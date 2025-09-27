@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <form action="">
            <div class="input-group">
                <input class="form-control" name="search" type="text" value="{{ request()->search }}" placeholder="@lang('Trx ID / Wallet')">
                <button class="input-group-text bg-base text-white">
                    <i class="las la-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="order-section pd-b-80">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12 mrb-30">
                <div class="order-table-area">
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
                                        <strong>{{ showAmount($withdrawal->amount, 8, exceptZeros: true, currencyFormat: false) }} {{ strtoupper($withdrawal->userCoinBalance->miner->coin_code) }}</strong>
                                    </td>

                                    <td>
                                        @php
                                            echo $withdrawal->statusBadge;
                                        @endphp
                                    </td>

                                    <td>
                                        @if ($withdrawal->status == Status::PAYMENT_SUCCESS || $withdrawal->status == Status::PAYMENT_REJECT)
                                            <button class="btn btn-icon btn-sm detailBtn" data-admin_feedback="{{ $withdrawal->admin_feedback }}"><i class="fas fa-desktop"></i></button>
                                        @else
                                            <a class="btn btn-icon btn-sm" href="{{ route('user.withdraw.preview', encrypt($withdrawal->id)) }}"><i class="fas fa-desktop"></i></a>
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
            </div>
        </div>
    </div>

    <div class="modal custom--modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
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
