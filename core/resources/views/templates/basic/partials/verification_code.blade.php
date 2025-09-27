<div class="mb-3">
    <label>@lang('Verification Code')</label>
    <div class="verification-code">
        <input class="form-control overflow-hidden" id="verification-code" name="code" type="text" required
            autocomplete="off">
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

@push('style-lib')
    <link href="{{ asset('assets/global/css/verification-code.css') }}" rel="stylesheet">
@endpush

@push('style')
    <style>
        .verification-code-wrapper {
            background-color: #fff;
            color: black;
            border: 0;
            box-shadow: 0px 3px 10px 0px rgb(0 0 0 / 10%);
            border-radius: 5px;
        }

        .verification-code span {
            background: #fff;
            border: 1px solid #ebebeb;
            color: black;
        }

        .verification-code input {
            color: black !important;
        }

        .verification-code::after {
            background-color: #fff;
        }
    </style>
@endpush

@push('script')
    <script>
        $('#verification-code').on('input', function() {
            $(this).val(function(i, val) {
                if (val.length >= 6) {
                    $('.submit-form').find('button[type=submit]').html(
                        '<i class="las la-spinner fa-spin"></i>');
                    $('.submit-form').submit()
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
