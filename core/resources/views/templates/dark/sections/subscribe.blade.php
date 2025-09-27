@php
    $content = getContent('subscribe.content', true);
@endphp

<section class="subscription py-50 bg-img">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-xl-6 col-lg-6 pe-lg-5">
                <h3 class="subscription-content__title mb-0">{{ __(@$content->data_values->heading) }}</h3>
            </div>
            <div class="col-xl-6 col-lg-6 ps-xl-5">
                <div class="subscription-content text-center">
                    <form class="call-to-action-form" action="#">
                        <div class="subscription-form">
                            <div class="input--group">
                                <input class="form--control" name="email" type="text" placeholder="@lang('Email Address')" autocomplete="off">
                                <button class="btn--base subscription-button px-4 py-2" type="submit">{{ __(@$content->data_values->button_text) }}</button>
                            </div>
                        </div>
                    </form>
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
