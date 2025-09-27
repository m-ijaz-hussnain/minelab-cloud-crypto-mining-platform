@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-120">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area">
                        <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form">
                            @csrf
                            <p class="verification-text">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}</p>

                            @include($activeTemplate . 'partials.verification_code')

                            <div class="mb-3">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                <small>
                                    @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span
                                            id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a
                                        href="{{ route('user.send.verify.code', 'email') }}"
                                        class="try-again-link text--base d-none"> @lang('Try again')</a>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    var distance =Number("{{@$user->ver_code_send_at->addMinutes(2)->timestamp-time()}}");
    var x = setInterval(function() {
        distance--;
        document.getElementById("countdown").innerHTML = distance;
        if (distance <= 0) {
            clearInterval(x);
            document.querySelector('.countdown-wrapper').classList.add('d-none');
            document.querySelector('.try-again-link').classList.remove('d-none');
        }
    }, 1000);
</script>
@endpush

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
