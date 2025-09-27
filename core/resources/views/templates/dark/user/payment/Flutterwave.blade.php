@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="card-title">@lang('Flutterwave')</h5>
        </div>
        <div class="card-body">
            <ul class="list-group gy-4 text-center">
                <li class="list-group-item d-flex justify-content-between">
                    @lang('You have to pay '):
                    <strong>{{ showAmount($deposit->final_amount, currencyFormat:false) }} {{ __($deposit->method_currency) }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    @lang('You will get '):
                    <strong>{{ showAmount($deposit->amount) }}</strong>
                </li>
            </ul>
            <button class="btn btn--base w-100 mt-3" id="btn-confirm" type="button" onClick="payWithRave()">@lang('Pay Now')</button>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{ $data->API_publicKey }}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{ $data->customer_email }}",
                amount: "{{ $data->amount }}",
                customer_phone: "{{ $data->customer_phone }}",
                currency: "{{ $data->currency }}",
                txref: "{{ $data->txref }}",
                onclose: function() {},
                callback: function(response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                    // x.close(); // use this to close the modal immediately after payment.
                }
            });
        }
    </script>
@endpush
