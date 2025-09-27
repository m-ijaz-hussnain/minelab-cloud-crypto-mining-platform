@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-xl-6 col-md-8 col-sm-8">
            <div class="profile-area">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">@lang('Current Password')</label>
                        <input class="form-control" name="current_password" type="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Password')</label>
                        <input type="password" class="form-control @if (gs('secure_password')) secure-password @endif" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Confirm Password')</label>
                        <input class="form-control" name="password_confirmation" type="password" required autocomplete="current-password">
                    </div>
                    <button class="submit-btn" type="submit">@lang('Submit')</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
