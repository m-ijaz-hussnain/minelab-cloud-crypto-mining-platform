<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__(@$customPageTitle ?? $pageTitle)) }}</title>

    @include('partials.seo')
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href=" {{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/style.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}" rel="stylesheet">

    @stack('style-lib')
    @stack('style')
</head>

@php echo  loadExtension('google-analytics') @endphp

<body>
    @stack('fbComment')
    <div class="preloader">
        <div class="loader-p"></div>
    </div>
    <div class="sidebar-overlay"></div>

    @yield('panel')

    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @stack('script-lib')

    @php echo  loadExtension('tawk-chat') @endphp

    @include('partials.notify')

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    @stack('script')

    <script>
        'use strict';
        (function($) {
            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });
        })(jQuery)
    </script>

</body>

</html>
