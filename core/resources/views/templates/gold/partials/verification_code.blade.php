<div class="mb-3">
    <label class="form--label">@lang('Verification Code')</label>
    <div class="verification-code">
        <input class="form-control overflow-hidden" id="verification-code" name="code" type="text" required autocomplete="off">
        <div class="boxes">
            <span>-</span>
            <span>-</span>
            <span>-</span>
            <span>-</span>
            <span>-</span>
            <span>-</span>
        </div>
    </div>
</div>

@push('style')
    <link href="{{ asset('assets/global/css/verification-code.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script>
        $('#verification-code').on('input', function() {
            $(this).val(function(i, val) {
                if (val.length >= 6) {
                    $('.submit-form').find('button[type=submit]').html('<i class="las la-spinner fa-spin"></i>');
                    $('.submit-form').submit();
                }
                if (val.length > 6) {
                    return val.substring(0, val.length - 1);
                }
                return val;
            });
            for (let index = $(this).val().length; index >= 0; index--) {
                $($('.boxes span')[index]).html('');
            }
        });
    </script>
@endpush

@push('style')
    <style>
        .verification-code-wrapper {
            background-color: hsl(var(--section-bg));
            border: 1px solid rgb(255 255 255 / 10%);
        }

        .verification-code span {
            background: #171f2a;
            border: solid 1px rgb(241 241 241 / 10%);
        }

        .verification-code::after {
            background-color: hsl(var(--section-bg));
            z-index: 2;
        }

        .verification-code input {
            color: #ffffff !important;
        }
    </style>
@endpush
