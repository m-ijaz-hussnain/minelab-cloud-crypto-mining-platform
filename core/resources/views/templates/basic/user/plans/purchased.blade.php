@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="order-section">

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th scope="col">@lang('S.N.')</th>
                                <th scope="col">@lang('Plan')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Return /Day')</th>
                                <th scope="col">@lang('Total Days')</th>
                                <th scope="col">@lang('Remaining Days')</th>
                                @if (!(request()->routeIs('user.home') || request()->routeIs('user.plans.active')))
                                    <th scope="col">@lang('Status')</th>
                                @endif
                                <th scope="col"> @lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $data)
                                <tr>
                                    <td>{{ $orders->firstItem() + $loop->index }}</td>
                                    <td>
                                        <small>
                                            {{ $data->plan_details->title }}
                                        </small>
                                    </td>
                                    <td>{{ showAmount($data->amount) }}</td>
                                    <td class="text-right">

                                        <div>
                                            @if ($data->min_return_per_day == $data->max_return_per_day)
                                                {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) }}
                                            @else
                                                {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) . ' - ' . showAmount($data->max_return_per_day, 8, exceptZeros: true, currencyFormat: false) }}
                                            @endif
                                            <small> {{ strtoupper($data->miner->coin_code) }}</small>
                                        </div>
                                    </td>

                                    <td>{{ $data->period }}</td>
                                    <td>
                                        {{ $data->period_remain }}
                                    </td>
                                    @if (!(request()->routeIs('user.home') || request()->routeIs('user.plans.active')))
                                        <td>
                                            @php
                                                echo $data->statusBadge;
                                            @endphp
                                        </td>
                                    @endif
                                    <td>
                                        <button class="btn btn-icon btn-sm viewBtn" data-date="{{ __(showDateTime($data->created_at, 'd M, Y')) }}" data-miner="{{ $data->plan_details->miner }}" data-order_id="{{ encrypt($data->id) }}" data-period={{ $data->period }} data-period_r={{ $data->period_remain }} data-plan="{{ $data->plan_details->title }}" data-price="{{ showAmount($data->amount) }}" data-rpd="@if ($data->min_return_per_day == $data->max_return_per_day) {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) }}
                                                    @else {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) . ' - ' . showAmount($data->max_return_per_day, 8, exceptZeros: true, currencyFormat: false) }} @endif
                                                    {{ strtoupper($data->miner->coin_code) }}" data-speed="{{ $data->plan_details->speed }}" data-status="{{ $data->status }}" data-trx="{{ $data->trx }}"><i class="las la-desktop"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ paginateLinks($orders) }}
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal custom--modal fade" id="viewModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0 border-0">
                        <h4 class="modal-title text-white">@lang('Track Details')</h4>
                        <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Created At')</span>
                                <span class="p-date"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Plan Title')</span>
                                <span class="plan-title"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Plan Price')</span>
                                <span class="plan-price"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Miner')</span>
                                <span class="miner-name"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Speed')</span>
                                <span class="speed"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Return /Day')</span>
                                <span class="plan-rpd"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Total Days')</span>
                                <span class="plan-period"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">@lang('Remaining Days')</span>
                                <span class="plan-period-r"></span>
                            </li>
                        </ul>

                        <div class="pay-btn pt-3">
                            <a class="cmn-btn w-100 text-center" href="">@lang('Pay Now')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .modal-footer {
            border-top: none;
        }
    </style>
@endpush

@push('script')
    <script>
        'use strict';
        (function($) {
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                let data = $(this).data();
                modal.find('.p-date').text(data.date)
                modal.find('.plan-title').text(data.plan)
                modal.find('.plan-price').text(data.price)
                modal.find('.miner-name').text(data.miner)
                modal.find('.speed').text(data.speed)
                modal.find('.plan-rpd').text(data.rpd)
                modal.find('.plan-period').text(data.period)
                modal.find('.plan-period-r').text(data.period_r)
                if (data.status == 0) {
                    modal.find('.pay-btn').show();
                    modal.find('.pay-btn a').attr('href', `{{ route('user.payment', '') }}/${data.order_id}`);
                } else {
                    modal.find('.pay-btn').hide();
                }

                modal.modal('show');
            })
        })(jQuery)
    </script>
@endpush
