@extends($activeTemplate . 'layouts.frontend')

@section('content')

    <section class="pricing-section pd-t-120 pd-b-120">
        <div class="container">
            @include($activeTemplate . 'partials.plan_card', ['miners' => $miners])
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
