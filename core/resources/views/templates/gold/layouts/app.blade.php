<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__(@$customPageTitle ?? $pageTitle)) }}</title>
    @include('partials.seo')
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/icon-moon.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">

    <link href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}" rel="stylesheet">

    @stack('style-lib')
    @stack('style')
</head>

@php echo  loadExtension('google-analytics') @endphp

<body>
    @stack('fbComment')
    @php
        $preloader = getContent('preloader.content', true);
    @endphp
    <div class="preloader flex-center">
        <div class="preloader__icon"><img src="{{ frontendImage('preloader', @$preloader->data_values->image, '100x100') }}" alt="@lang('image')"></div>
    </div>
    <div class="body-overlay"></div>
    <div class="sidebar-overlay"></div>
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

    @yield('panel')

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
            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });

            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });

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
