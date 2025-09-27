@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="card-title">@lang('Payment Via') {{ __($data->gateway->name) }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.deposit.manual.update') }}" method="POST" class="disableSubmission" enctype="multipart/form-data">
                @csrf
                <div class="row gy-4">
                    <div class="col-sm-12 text-center">
                        <p class="text-center">@lang('You have requested') <b class="text--success">{{ showAmount($data['amount']) }}</b> , @lang('Please pay')
                            <b class="text--success">{{ showAmount($data['final_amount'], currencyFormat:false) . ' ' . $data['method_currency'] }} </b> @lang('for successful payment')
                        </p>
                        <h4 class="my-4 text-center">@lang('Please follow the instruction below')</h4>

                        <div class="text-center">@php echo  $data->gateway->description @endphp</div>
                    </div>

                    <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}" />

                    <div class="col-sm-12">
                        <div class="form-group">
                            <button class="btn btn--base w-100" type="submit">@lang('Pay Now')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
