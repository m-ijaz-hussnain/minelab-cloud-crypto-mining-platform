@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')
    @include($activeTemplate . 'partials.breadcrumb')
    <section class="dashboard-section ptb-80">
        <div class="container">
            @yield('content')
        </div>
    </section>
    @include($activeTemplate . 'partials.footer')
@endsection
