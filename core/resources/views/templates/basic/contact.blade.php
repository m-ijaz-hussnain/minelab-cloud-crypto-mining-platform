@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $content = getContent('contact_us.content', true);
    @endphp

    <!-- contact-section start -->
    <section class="contact-section register-section pd-t-120">
        <div class="container">

            <div class="row">
                <div class="col-lg-5 d-lg-block d-none">
                    <div class="contact-thumb">
                        <img src="{{ frontendImage('contact_us', @$content->data_values->image, '618x406') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="register-form-area">
                        <h3 class="title mb-4">{{ __(@$content->data_values->heading) }}</h3>
                        <span class="title-border"></span>
                        <form class="register-form verify-gcaptcha" method="POST">
                            @csrf
                            <div class="row justify-content-center ml-b-20">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-pen"></i></label>
                                        <input class="form-control" name="name" type="text" value="{{ old('name', @$user->fullname) }}" @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-envelope"></i></label>
                                        <input class="form-control" name="email" type="email" value="{{ old('email', @$user->email) }}" @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="register-icon"><i class="fas fa-book"></i></label>
                                        <input class="form-control" name="subject" type="text" value="{{ old('subject') }}" placeholder="@lang('Subject')" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" rows="5" placeholder="@lang('Your Message')" required>{{ old('message') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <x-captcha />
                                </div>
                            </div>

                            <button class="submit-btn mt-3" id="recaptcha" type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-section end -->

    <!-- contact-info start -->
    <div class="contact-info-area ptb-120">
        <div class="container">
            <div class="contact-info-item-area">
                <div class="row gy-4">
                    <div class="col-md-4 col-sm-12">
                        <div class="contact-info-item">
                            <i class="fas fa fa-map-marker-alt"></i>
                            <h3 class="title">@lang('Address')</h3>
                            <p>{{ __(@$content->data_values->contact_details) }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="contact-info-item item-one">
                            <i class="fas fa-envelope"></i>
                            <h3 class="title">@lang('Email Address')</h3>
                            <p><a href="mailto:{{ @$content->data_values->email_address }}">{{ @$content->data_values->email_address }}</a></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="contact-info-item item-two">
                            <i class="fas fa-phone-alt"></i>
                            <h3 class="title">@lang('Phone Number')</h3>
                            <p><a href="tel:{{ @$content->data_values->contact_number }}">{{ @$content->data_values->contact_number }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact-info end -->

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
