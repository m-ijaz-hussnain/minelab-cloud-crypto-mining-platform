@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="pricing-section">
        @include($activeTemplate . 'partials.plan_card', ['miners' => $miners])
    </div>
@endsection
