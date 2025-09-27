@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('contact_us.content', true);
    @endphp
    <section class="contact py-60">
        <div class="contact-info py-60">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="contact-item flex-align">
                            <span class="contact-item__icon flex-center"><i class="fas fa-map-marker-alt"></i></span>
                            <div class="contact-item__content">
                                <h5 class="contact-item__title">@lang('Office Address')</h5>
                                <p class="contact-item__desc"> {{ __(@$content->data_values->contact_details) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="contact-item flex-align">
                            <span class="contact-item__icon flex-center"><i class="fas fa-envelope"></i></span>
                            <div class="contact-item__content">
                                <h5 class="contact-item__title">@lang('Email Address')</h5>
                                <p class="contact-item__desc"><a href="mailto:{{ @$content->data_values->email_address }}">{{ @$content->data_values->email_address }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="contact-item flex-align">
                            <span class="contact-item__icon flex-center"><i class="fas fa-phone"></i></span>
                            <div class="contact-item__content">
                                <h5 class="contact-item__title">@lang('Mobile')</h5>
                                <p class="contact-item__desc"><a href="tel:{{ @$content->data_values->contact_number }}">{{ @$content->data_values->contact_number }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-form-wrapper py-60">
            <div class="container">
                <form action="#" class="contact-form" method="POST">
                    @csrf
                    <h4 class="contact-form__title">{{ __(@$content->data_values->heading) }}</h4>
                    <div class="form-group">
                        <label for="fullname" class="form--label">@lang('Full Name')</label>
                        <div class="position-relative">
                            <input name="name" type="text" class="form--control" value="{{ old('name', @$user->fullname) }}" @if ($user && $user->profile_complete) readonly @endif required>
                            <span class="input-icon"><i class="far fa-user"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form--label">@lang('Email Address')</label>
                        <div class="position-relative">
                            <input name="email" type="email" class="form--control" value="{{ old('email', @$user->email) }}" @if ($user && $user->profile_complete) readonly @endif required>
                            <span class="input-icon"><i class="far fa-envelope"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="form--label">@lang('Subject')</label>
                        <div class="position-relative">
                            <input type="text" class="form--control" id="subject" name="subject" value="{{ old('subject') }}" required>
                            <span class="input-icon"><i class="lab la-elementor"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="form--label">@lang('Message')</label>
                        <div class="position-relative">
                            <textarea id="message" class="form--control" name="message" required>{{ old('message') }}</textarea>
                            <span class="input-icon"><i class="fas fa-pencil-alt"></i></span>
                        </div>
                    </div>
                    <x-captcha />
                    <div class="form-group mb-0">
                        <button type="submit" id="recaptcha" class="btn btn--base pill">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
