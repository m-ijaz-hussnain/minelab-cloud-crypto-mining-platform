@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center ptb-120">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="mb-4">
                            <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                        </div>
                        <form method="POST" action="{{ route('user.password.update') }}">
                            @csrf
                            <input name="email" type="hidden" value="{{ $email }}">
                            <input name="token" type="hidden" value="{{ $token }}">
                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input class="form-control form--control @if (gs('secure_password')) secure-password @endif" name="password" type="password" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Confirm Password')</label>
                                <input class="form-control form--control" name="password_confirmation" type="password" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn--base w-100" type="submit"> @lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
