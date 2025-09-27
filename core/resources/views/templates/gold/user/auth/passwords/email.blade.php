@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="mb-4">
                                <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                            </div>
                            <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha">
                                @csrf
                                <div class="form-group">
                                    <label class="form--label">@lang('Email or Username')</label>
                                    <input class="form--control" name="value" type="text" value="{{ old('value') }}"
                                        required autofocus="off">
                                </div>
                                <x-captcha />
                                <button class="btn btn-outline--base w-100" type="submit">@lang('Submit')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('style')
    <style>
        .verification-code-wrapper {
            border: 1px solid rgb(235 235 235 / 10%) !important;
            background-color: transparent !important;
        }

        .verification-code::after {
            background-color: #171f2a !important;
        }

        .verification-code span {
            background: #2a313b !important;
            border: solid 1px rgb(241 241 241 / 10%) !important;
        }

        .verification-code input {
            color: #d8d3d3 !important;
        }
    </style>
@endpush
