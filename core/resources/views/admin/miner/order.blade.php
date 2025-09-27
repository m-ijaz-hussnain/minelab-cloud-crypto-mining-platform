@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two custom-data-table table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Order ID')</th>
                                    <th>@lang('Plan Title')</th>
                                    <th>@lang('Miner')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Period')</th>
                                    <th>@lang('Retun /Day')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($orders as $order)
                                    <tr>
                                        <td> {{ $orders->firstItem() + $loop->index }}</td>
                                        <td> {{ $order->trx }} </td>
                                        <td> {{ __($order->plan_details->title) }} </td>
                                        <td> {{ __($order->plan_details->miner) }} </td>
                                        <td> {{ showAmount($order->amount) }}</td>
                                        <td> {{ $order->plan_details->period }}</td>
                                        <td>
                                            {{ showAmount($order->min_return_per_day, 8, exceptZeros:true, currencyFormat:false) }} - {{ showAmount($order->max_return_per_day, 8, exceptZeros:true, currencyFormat:false) }} <strong>{{ strtoupper($order->miner->coin_code) }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                echo $order->statusBadge;
                                            @endphp
                                        </td>

                                        <td>
                                            <button class="btn btn-outline--primary btn-sm detailBtn" data-status_badge="{{ $order->statusBadge }}" data-order="{{ $order }}" data-purchase_date="{{ showDateTime($order->created_at) }}" data-plan_title="{{ __($order->plan_details->title) }}" data-plan_price="{{ showAmount($order->amount) }}" data-status="{{ $order->status }}" data-deposit_id="{{ @$order->deposit->id }}" @if ($order->status != Status::ORDER_UNPAID) data-payment_via="{{ @$order->deposit ? @$order->deposit->methodName() : 'Wallet Balance' }}" @endif><i class="las la-desktop"></i>@lang('Detail')</button>
                                        </td>
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
                @if ($orders->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($orders) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush userData mb-2">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="fw-bold">@lang('Purchased At')</span>
                            <span class="purchase-date"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="fw-bold">@lang('Plan Title')</span>
                            <span class="plan-title"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="fw-bold">@lang('Price')</span>
                            <span class="plan-price"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center payment-li px-0">
                            <span class="fw-bold">@lang('Payment Via')</span>
                            <span class="payment-via"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="fw-bold">@lang('Status')</span>
                            <span class="order-status"></span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <a class="btn btn--primary w-100 h-45" href="">@lang('Approve Payment')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Order ID" />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                let data = $(this).data();

                modal.find('.purchase-date').html(data.purchase_date);
                modal.find('.plan-title').html(data.plan_title);
                modal.find('.plan-price').html(data.plan_price);
                if (data.status != {{ Status::ORDER_UNPAID }}) {
                    modal.find('.payment-li').removeClass('d-none');
                    modal.find('.payment-via').html(data.payment_via)
                } else {
                    modal.find('.payment-li').addClass('d-none');
                }

                if (data.status == {{ Status::ORDER_PENDING }}) {
                    modal.find('.modal-footer').removeClass('d-none');
                    modal.find('.modal-footer a').attr('href', `{{ route('admin.payment.details', '') }}/${data.deposit_id}`);
                } else {
                    modal.find('.modal-footer').addClass('d-none');
                }
                modal.find('.order-status').html(data.status_badge);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
