@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include($activeTemplate . 'partials.purchased_plan', ['orders' => $orders, 'paginate' => true])
        </div>
    </div>
@endsection
