@php
    $subscribe = getContent('subscribe.content', true);
@endphp

<section class="subscribe section-bg bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/thumbs/subscribe-bg.png') }}">
    <div class="container">
        <div class="subscribe__inner">
            <img src="{{ frontendImage('subscribe' , @$subscribe->data_values->image, '260x250') }}" alt="@lang('image')" class="subscribe__thumb d-lg-block d-none">
            <div class="row align-items-end">
                <div class="col-xl-5 col-lg-8">
                    <form action="#" class="subscribe-form call-to-action-form">
                        <h4 class="subscribe-form__title">{{ __(@$subscribe->data_values->heading) }}</h4>
                        <div class="input-group">
                            <input type="text" class="form--control form-control" name="email" placeholder="@lang('Your Email Address')" autocomplete="off">
                            <button type="submit" class="input-group-text btn btn--base flex-align">
                                <span class="icon"><span class="icon-navigation-2-fill"></span></span>
                                {{ __(@$subscribe->data_values->button_text) }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-xl-4 d-xl-block d-none">
                    <img src="{{ frontendImage('subscribe' , @$subscribe->data_values->arrow_image, '335x65') }}" alt="@lang('image')" class="subscribe__arrow">
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        'use strict';
        (function($) {
            $(document).on('submit', '.call-to-action-form', function(e) {
                e.preventDefault();
                var email = $('[name="email"]').val();
                if (!email) {
                    notify('error', 'Email field is required');
                } else {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        url: "{{ route('subscribe') }}",
                        method: "POST",
                        data: {
                            email: email
                        },
                        success: function(response) {
                            if (response.success) {
                                notify('success', response.success);
                            } else {
                                notify('error', response.error);
                            }
                            $('input[name="email"]').val('');
                        }
                    });
                }

            });
        })(jQuery)
    </script>
@endpush
