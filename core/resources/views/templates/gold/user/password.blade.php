@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card custom--card">
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">@lang('Current Password')</label>
                            <input autocomplete="current-password" class="form--control" name="current_password" required
                                type="password">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Password')</label>
                            <input type="password"
                                class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                name="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Confirm Password')</label>
                            <input autocomplete="current-password" class="form--control" name="password_confirmation"
                                required type="password">
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-outline--base w-100" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
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
