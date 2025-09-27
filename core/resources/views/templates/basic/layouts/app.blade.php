<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @include('partials.seo')
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/style.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}" rel="stylesheet">
    @stack('style-lib')
    @stack('style')
</head>

@php echo  loadExtension('google-analytics') @endphp

<body>
    <div class="sidebar-overlay"></div>
    <div class="body-overlay"></div>
    @include($activeTemplate . 'partials.preloader')
    @yield('panel')
    <a class="scrollToTop" href="#"><i class="fa fa-angle-double-up"></i></a>

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/swiper.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.nice-select.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/chart.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/particles.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @stack('script-lib')

    @include('partials.notify')

    @php echo  loadExtension('tawk-chat') @endphp

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    @stack('script')
    <script>
        'use strict';
        (function($) {
            let captcha = $('[name=captcha]');

            if (captcha) {
                $(captcha).addClass('ps-2');
                $(captcha).attr('placeholder', "@lang('Enter the code above')");
                $(captcha).siblings('label').remove();
            }

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
