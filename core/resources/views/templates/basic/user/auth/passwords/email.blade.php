@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center ptb-120">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="mb-4">
                            <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                        </div>
                        <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">@lang('Email or Username')</label>
                                <input class="form-control form--control" name="value" type="text" value="{{ old('value') }}" required autofocus="off">
                            </div>

                            <x-captcha />

                            <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
