@extends($activeTemplate . 'layouts.frontend')
@php
    $content = getContent('plan.content', true);
@endphp
@section('content')
    @if ($miners->isNotEmpty())
        <section class="plan py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        @include($activeTemplate . 'partials.plan_card', ['miners' => $miners])
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
