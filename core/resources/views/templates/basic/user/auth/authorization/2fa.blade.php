@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="ptb-120">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area">
                        <form class="submit-form" action="{{ route('user.2fa.verify') }}" method="POST">
                            @csrf
                            @include($activeTemplate . 'partials.verification_code')
                            <div class="form--group">
                                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
