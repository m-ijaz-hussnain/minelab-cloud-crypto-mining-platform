@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.auth_header')
    @include($activeTemplate . 'partials.breadcrumb')
    <section class="dashboard py-120">
        <div class="container">
            @yield('content')
        </div>
    </section>
    @include($activeTemplate . 'partials.footer')
@endsection
