@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="d-sm-flex justify-content-end d-block mb-3">
        <form action="">
            <div class="input-group">
                <input class="form-control form--control" name="search" placeholder="@lang('Search by transactions')" type="text" value="{{ request()->search }}">
                <button class="input-group-text append-icon--btn" type="submit">
                    <i class="las la-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="dashboard-table">
        <table class="table--responsive--xl table">
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
                            <div class="fw-bold">
                                <span class="text-primary d-block">{{ __($deposit->gateway?->name) }}</span>
                                <small> {{ $deposit->trx }} </small>
                            </div>
                        </td>

                        <td class="text-center">
                            <div>
                                <small class="d-block">{{ showDateTime($deposit->created_at) }}</small>
                                <small>{{ diffForHumans($deposit->created_at) }}</small>
                            </div>
                        </td>

                        <td class="text-center">
                            <div>
                                <small class="d-block">{{ showAmount($deposit->amount) }} + <span class="text-danger" data-bs-toggle="tooltip" title="@lang('charge')">{{ showAmount($deposit->charge) }} </span></small>

                                <small data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                    <strong>{{ showAmount($deposit->amount + $deposit->charge) }}</strong>
                                </small>
                            </div>
                        </td>
                        <td class="text-center">
                            <div>
                                <small class="d-block"> 1 {{ __(gs('cur_text')) }} = {{ showAmount($deposit->rate, currencyFormat: false) }} {{ __($deposit->method_currency) }}</small>
                                <strong>{{ showAmount($deposit->final_amount, currencyFormat: false) }} {{ __($deposit->method_currency) }}</strong>
                            </div>
                        </td>
                        <td class="text-center">
                            @php echo $deposit->statusBadge @endphp
                        </td>
                        @php
                            $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                        @endphp

                        <td>
                            <button @if ($deposit->method_code < 1000) disabled @endif @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif class="btn--base btn--xsm @if ($deposit->method_code >= 1000) detailBtn @endif" type="button">
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

    {{-- Detail MODAL --}}
    <div class="modal custom--modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData">
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
