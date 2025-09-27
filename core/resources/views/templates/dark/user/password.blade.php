@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="card-title">
                @lang('Change Password')
            </h5>
        </div>
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label">@lang('Current Password')</label>
                    <input autocomplete="current-password" class="form--control" name="current_password" required type="password">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Password')</label>
                    <input type="password" class="form--control @if (gs('secure_password')) secure-password @endif" name="password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Confirm Password')</label>
                    <input autocomplete="current-password" class="form--control" name="password_confirmation" required type="password">
                </div>
                <button class="btn--base w-100" type="submit">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush

@push('script')
    @if (gs('secure_password'))
        <script>
            (function($) {
                "use strict";
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('div').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('div').removeClass('hover-input-popup');
                });
            })(jQuery);
        </script>
    @endif
@endpush
