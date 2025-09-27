@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="d-flex justify-content-end mb-3">
        <x-search-form btn="btn--base" placeholder="Search by transactions" />
    </div>
    <div class="order-section pd-b-80">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12 mrb-30">
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th>@lang('Gateway | Transaction')</th>
                                <th class="text-center">@lang('Initiated')</th>
                                <th class="text-center">@lang('Amount')</th>
                                <th class="text-center">@lang('Conversion')</th>
                                <th class="text-center">@lang('Status')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deposits as $deposit)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <span class="fw-bold"> <span class="text-primary">{{ __($deposit->gateway?->name) }}</span> </span>
                                            <small> {{ $deposit->trx }} </small>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <small>{{ showDateTime($deposit->created_at) }}</small>
                                            <small>{{ diffForHumans($deposit->created_at) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <small>{{ showAmount($deposit->amount) }} + <span class="text-danger" data-bs-placement="right" data-bs-toggle="tooltip" title="@lang('charge')">{{ showAmount($deposit->charge) }} </span></small>
                                            <small data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                                <strong>{{ showAmount($deposit->amount + $deposit->charge) }}</strong>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column flex-wrap">
                                            <small> 1 {{ __(gs('cur_text')) }} = {{ showAmount($deposit->rate, currencyFormat: false) }} {{ __($deposit->method_currency) }}</small>
                                            <small class="fw-bold">{{ showAmount($deposit->final_amount, currencyFormat: false) }} {{ __($deposit->method_currency) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @php echo $deposit->statusBadge @endphp
                                    </td>
                                    @php
                                        $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                    @endphp

                                    <td>
                                        <button @if ($deposit->method_code < 1000) disabled @endif @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif class="btn btn-icon btn-sm @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif" type="button">
                                            <i class="las la-desktop"></i>
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
                    {{ paginateLinks($deposits) }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom--modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
