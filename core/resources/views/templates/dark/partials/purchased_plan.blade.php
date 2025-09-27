<div class="dashboard-table">
    <table class="table--responsive--lg table">
        <thead>
            <tr>
                <th scope="col">@lang('Plan')</th>
                <th scope="col">@lang('Price')</th>
                <th scope="col">@lang('Return /Day')</th>
                <th scope="col">@lang('Total Days')</th>
                <th scope="col">@lang('Remaining Days')</th>
                @if (!request()->routeIs('user.plans.active'))
                    <th scope="col"> @lang('Status')</th>
                @endif
                <th scope="col"> @lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $data)
                <tr>
                    <td>{{ $data->plan_details->title }}</td>
                    <td>
                        {{ showAmount($data->amount) }}
                    </td>
                    <td>
                        @if ($data->min_return_per_day == $data->max_return_per_day)
                            {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) }}
                        @else
                            {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) . ' - ' . showAmount($data->max_return_per_day, 8, exceptZeros: true, currencyFormat: false) }}
                        @endif
                        {{ strtoupper($data->miner->coin_code) }}
                    </td>

                    <td>{{ $data->period }}</td>
                    <td>
                        {{ $data->period_remain }}
                    </td>
                    @if (!request()->routeIs('user.plans.active'))
                        <td>
                            @php
                                echo $data->statusBadge;
                            @endphp
                        </td>
                    @endif
                    <td>
                        <button class="btn--base btn--xsm viewBtn"
                            data-date="{{ __(showDateTime($data->created_at, 'd M, Y')) }}"
                            data-trx="{{ $data->trx }}" data-plan="{{ $data->plan_details->title }}"
                            data-miner="{{ $data->plan_details->miner }}"
                            data-speed="{{ $data->plan_details->speed }}" data-price="{{ showAmount($data->amount) }}"
                            data-rpd="@if ($data->min_return_per_day == $data->max_return_per_day) {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) }} @else {{ showAmount($data->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) . ' - ' . showAmount($data->max_return_per_day, 8, exceptZeros: true, currencyFormat: false) }} @endif {{ strtoupper($data->miner->coin_code) }}"
                            data-period={{ $data->period }} data-period_r={{ $data->period_remain }}
                            data-status="{{ $data->status }}"
                            @if ($data->status == 0) data-order_id="{{ encrypt($data->id) }}" @endif><i
                                class="las la-desktop"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        @if ($paginate)
            {{ paginateLinks($orders) }}
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal custom--modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h4 class="modal-title text-white">@lang('Track Details')</h4>
                <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
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
            </div>
            <div class="modal-footer">
                <a class="btn btn--base w-100" href="">@lang('Pay Now')</a>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        'use strict';
        (function($) {
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');

                let data = $(this).data();
                modal.find('.p-date').text(data.date);
                modal.find('.plan-title').text(data.plan);
                modal.find('.plan-price').text(data.price);
                modal.find('.miner-name').text(data.miner);
                modal.find('.speed').text(data.speed);
                modal.find('.plan-rpd').text(data.rpd);
                modal.find('.plan-period').text(data.period);
                modal.find('.plan-period-r').text(data.period_r);

                if (data.status == 0) {
                    modal.find('.modal-footer').show();
                    modal.find('.modal-footer a').attr('href',
                        `{{ route('user.payment', '') }}/${data.order_id}`);
                } else {
                    modal.find('.modal-footer').hide();
                }
                modal.modal('show');
            })
        })(jQuery)
    </script>
@endpush
