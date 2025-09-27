@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-3 justify-content-center">
        <div class="col-md-12  d-lg-none d-block">
            <div class="show-filter text-end">
                <button class="btn btn--base showFilterBtn" type="button"><i class="las la-filter"></i> @lang('Filter')</button>
            </div>
        </div>

        <div class="col-12">
            <div class="card custom--card responsive-filter-card">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label class="form--label">@lang('Transaction Number')</label>
                                <input class="form-control form--control" name="search" type="text" value="{{ request()->search }}">
                            </div>
                            <div class="flex-grow-1">
                                <label class="form--label">@lang('Type')</label>
                                <select class="select form--control" name="type">
                                    <option value="">@lang('All')</option>
                                    <option @selected(request()->type == '+') value="+">@lang('Plus')</option>
                                    <option @selected(request()->type == '-') value="-">@lang('Minus')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label class="form--label">@lang('Coin Code')</label>
                                <select class="select form--control" name="coin_code">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($coins as $coin)
                                        <option @selected(request()->coin_code == $coin->currency) value="{{ $coin->currency }}">{{ __(strtoupper($coin->currency)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label class="form--label">@lang('Remark')</label>
                                <select class="select form--control" name="remark">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($remarks as $remark)
                                        <option @selected(request()->remark == $remark->remark) value="{{ $remark->remark }}">{{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--base w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="dashboard-table">
                @include($activeTemplate . 'partials.transaction_table', ['transactions' => $transactions])
                {{ paginateLinks($transactions) }}
            </div>
        </div>
    </div>
@endsection
