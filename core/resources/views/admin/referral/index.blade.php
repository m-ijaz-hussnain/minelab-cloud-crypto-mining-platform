@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-lg-5 mb-4">
            <div class="card parent">
                <div class="card-body">

                    <ul class="list-group list-group-flush">
                        @foreach ($referrals as $referral)
                            <li class="list-group-item d-flex justify-content-between flex-wrap">
                                <span class="fw-bold">@lang('Level') {{ $referral->level }}</span>
                                <span class="fw-bold">{{ $referral->percent }}%</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="border-line-area mt-3">
                        <h6 class="border-line-title">@lang('Update Setting')</h6>
                    </div>

                    <div class="form-group">
                        <label>@lang('Number of Level')</label>
                        <div class="input-group">
                            <input class="form-control" min="1" name="level" placeholder="@lang('Type a number & hit ENTER  ↵')" type="number">
                            <button class="btn btn--primary generate" type="button">@lang('Generate')</button>
                        </div>
                        <span class="text--danger required-message d-none">@lang('Please enter a number')</span>
                    </div>

                    <form action="{{ route('admin.setting.referral.update') }}" class="d-none levelForm" method="post">
                        @csrf
                        <h6 class="text--danger mb-3">@lang('The Old setting will be removed after generating new')</h6>
                        <div class="form-group">
                            <div class="referralLevels"></div>
                        </div>
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .border-line-area {
            position: relative;
            text-align: center;
            z-index: 1;
        }

        .border-line-area::before {
            position: absolute;
            content: '';
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e5e5e5;
            z-index: -1;
        }

        .border-line-title {
            display: inline-block;
            padding: 3px 10px;
            background-color: #fff;
        }

        .input-group-text {
            border-top-right-radius: 4px !important;
            border-bottom-right-radius: 4px !important;
        }

        .input-group-text.btn--danger {
            border-top-left-radius: 4px !important;
            border-bottom-left-radius: 4px !important;
        }

        .btn-square {
            display: grid;
            place-content: center;
        }

        .btn-square i {
            margin: 0;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"

            $('[name="level"]').on('focus', function() {
                $(this).on('keyup', function(e) {
                    if (e.which == 13) {
                        generrateLevels($(this));
                    }
                });
            });

            $(".generate").on('click', function() {
                let $this = $(this).parents('.card-body').find('[name="level"]');
                generrateLevels($this);
            });

            $(document).on('click', '.deleteBtn', function() {
                $(this).closest('.input-group').remove();
                $.each($('.referral-level'), function(index, element) {
                    $(element).text(`Level ${index+1}`);
                });
            });

            function generrateLevels($this) {
                let numberOfLevel = $this.val();
                let parent = $this.parents('.card-body');
                let html = '';
                if (numberOfLevel && numberOfLevel > 0) {
                    parent.find('.levelForm').removeClass('d-none');
                    parent.find('.required-message').addClass('d-none');

                    for (i = 1; i <= numberOfLevel; i++) {
                        html += `
                    <div class="input-group mb-3">
                        <span class="input-group-text referral-level justify-content-center">@lang('Level') ${i}</span>
                        <input type="hidden" name="level[]" value="${i}" required>
                        <input name="percent[]" class="form-control col-10" type="number" step="any" required>
                        <span class="input-group-text">%</span>
                        <button class="btn btn--danger btn-square input-group-text deleteBtn ms-2" type="button"><i class=\'la la-times\'></i></button>
                    </div>`
                    }

                    parent.find('.referralLevels').html(html);
                } else {
                    parent.find('.levelForm').addClass('d-none');
                    parent.find('.required-message').removeClass('d-none');
                }
            }

        })(jQuery);
    </script>
@endpush
