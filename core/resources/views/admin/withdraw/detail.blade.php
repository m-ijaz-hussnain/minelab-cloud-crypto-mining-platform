@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">

        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card box--shadow1 overflow-hidden">
                <div class="card-body">
                    <h5 class="text-muted mb-20">@lang('Withdraw from - ') <span class="fw-bold">{{ strtoupper($withdrawal->userCoinBalance->miner->coin_code) }} @lang('Wallet')</span></h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Date')
                            <span class="fw-bold">{{ showDateTime($withdrawal->created_at) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Trx Number')
                            <span class="fw-bold">{{ $withdrawal->trx }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $withdrawal->user_id) }}">{{ @$withdrawal->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Payable Amount')
                            <span class="fw-bold">{{ showAmount($withdrawal->amount, 8, exceptZeros: true, currencyFormat: false) }} {{ __(strtoupper($withdrawal->userCoinBalance->miner->coin_code)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @php echo $withdrawal->statusBadge @endphp
                        </li>

                        @if ($withdrawal->admin_feedback)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Admin Response')
                                <p>{{ $withdrawal->admin_feedback }}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6 mb-30">

            <div class="card box--shadow1 overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">@lang('User Withdraw Information')</h5>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6>@lang('Wallet Address'):</h6>
                            <p>{{ __($withdrawal->userCoinBalance->wallet) }}</p>
                        </div>
                    </div>

                    @if ($withdrawal->status == Status::PAYMENT_PENDING)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button class="btn btn-outline--success btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="las la-check"></i> @lang('Approve')
                                </button>

                                <button class="btn btn-outline--danger btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="las la-ban"></i> @lang('Reject')
                                </button>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approve Withdrawal Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.withdraw.data.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $withdrawal->id }}">
                    <div class="modal-body">
                        <p>@lang('Have you sent') <span class="fw-bold text--success">{{ showAmount($withdrawal->final_amount, currencyFormat: false) }} {{ $withdrawal->currency }}</span>?</p>
                        <textarea name="details" class="form-control" value="{{ old('details') }}" rows="3" placeholder="@lang('Provide the details. eg: transaction number')" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Withdrawal Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.withdraw.data.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $withdrawal->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Reason of Rejection')</label>
                            <textarea name="details" class="form-control" rows="3" value="{{ old('details') }}" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
