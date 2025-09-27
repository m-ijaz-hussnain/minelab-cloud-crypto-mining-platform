@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')

    @if (!request()->routeIs('home'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif

    @yield('content')

    @include($activeTemplate . 'partials.footer')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <div class="cookies-card hide text-center">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="mt-4">{{ __($cookie->data_values->short_desc) }} <a class="text--base" href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
            <div class="cookies-card__btn mt-4">
                <a class="btn btn--base w-100 policy" href="javascript:void(0)">@lang('Allow')</a>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        (function($) {
            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });
            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);
        })(jQuery)
    </script>
@endpush
