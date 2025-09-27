@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="card custom--card card-deposit">
        <div class="card-header">
            <h5 class="card-title">@lang('Payment Preview')</h5>
        </div>
        <div class="card-body card-body-deposit text-center">
            <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{ __($data->currency) }}</h4>
            <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
            <img src="{{ $data->img }}" alt="@lang('Image')">
            <h4 class="bold mt-4 text-white">@lang('SCAN TO SEND')</h4>
        </div>
    </div>
@endsection
