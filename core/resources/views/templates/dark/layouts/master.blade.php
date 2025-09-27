@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')
    <div class="dashboard py-100 section-bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 pe-xl-4">
                    @include($activeTemplate . 'partials.sidenav')
                </div>
                <div class="col-xl-9 col-lg-8 position-relative">
                    <div class="sidenav-bar d-lg-none d-block">
                        <span class="sidenav-bar__icon">
                            <i class="las la-sliders-h"></i>
                        </span>
                    </div>
                    <div class="dashboard-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include($activeTemplate . 'partials.footer')
@endsection
