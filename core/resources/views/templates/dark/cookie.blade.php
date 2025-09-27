@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="dashboard-section py-100">
        <div class="container">
            <div class="wb-break-all">@php echo $cookie->data_values->description; @endphp</div>
        </div>
    </div>
@endsection
