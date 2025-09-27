@php
    $content = getContent('subscribe.content', true);
@endphp
<section class="subscribe-section call-to-action-section pd-t-60 pd-b-60">
    <div class="container">
        <div class="call-to-action-area">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 text-center">
                    <div class="call-to-action-content">
                        <h2 class="title">{{ __(@$content->data_values->heading) }}</h2>
                        <form class="call-to-action-form">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <input name="email" type="email" placeholder="@lang('Your Email Address')">
                                    <button class="submit-btn mt-0 w-auto" type="submit"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                    notify('error', 'Email is required');
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
                            $('[name="email"]').val('');
                        }
                    });
                }

            });
        })(jQuery)
    </script>
@endpush
