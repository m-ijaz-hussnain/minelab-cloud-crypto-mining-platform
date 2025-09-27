@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="card-title">@lang('Razorpay')</h5>
        </div>
        <div class="card-body">
            <ul class="list-group text-center">
                <li class="list-group-item d-flex justify-content-between">
                    @lang('You have to pay '):
                    <strong>{{ showAmount($deposit->final_amount, currencyFormat:false) }} {{ __($deposit->method_currency) }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    @lang('You will get '):
                    <strong>{{ showAmount($deposit->amount) }}</strong>
                </li>
            </ul>
            <form action="{{ $data->url }}" method="{{ $data->method }}">
                <input name="hidden" type="hidden" custom="{{ $data->custom }}">
                <script src="{{ $data->checkout_js }}" @foreach ($data->val as $key => $value)
                    data-{{ $key }}="{{ $value }}" @endforeach></script>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('input[type="submit"]').addClass("mt-4 btn btn--base w-100");
        })(jQuery);
    </script>
@endpush
