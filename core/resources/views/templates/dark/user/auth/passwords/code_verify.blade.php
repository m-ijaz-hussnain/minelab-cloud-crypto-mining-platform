@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account section-bg py-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper">
                            <div class="verification-area">
                                <form action="{{ route('user.password.verify.code') }}" class="submit-form" method="POST">
                                    @csrf
                                    <p class="verification-text mb-2">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                                    <input name="email" type="hidden" value="{{ $email }}">

                                    @include($activeTemplate . 'partials.verification_code')

                                    <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                                    <div class="mt-2">
                                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                        <a class="text--base" href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                    </div>

                                </form>
                            </div>
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
            background-color: rgb(30 38 49);
            border-color: #ebebeb17;
        }

        .verification-area h5 {
            border-bottom: 1px solid #ebebeb17 !important;
        }

        .verification-code span {
            background: #f1f1f10a;
            border: solid 1px #f1f1f124;
            color: #fff;
        }

        .verification-code input {
            color: rgba(255, 255, 255, 0.817) !important;
            font-weight: 500;
        }

        .verification-code::after {
            background-color: rgb(30 38 49);
        }
    </style>
@endpush
