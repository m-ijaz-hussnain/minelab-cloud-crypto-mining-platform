@extends($activeTemplate . 'layouts.master')

@section('content')
    <h5>{{ __($pageTitle) }}</h5>
    @include($activeTemplate . 'partials.purchased_plan', ['orders' => $orders, 'paginate' => true])
@endsection
