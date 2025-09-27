@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Site Title')</label>
                                    <input class="form-control" type="text" name="site_name" required
                                        value="{{ gs('site_name') }}">
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label> @lang('Preloader Title')
                                        <small class="text--small text--danger">
                                            <i class="las la-info-circle"></i>
                                            @lang('Maximum 10 characters are allowed')
                                        </small>
                                    </label>
                                    <input class="form-control" name="preloader_title" type="text"
                                        value="{{ gs('preloader_title') }}">
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency')</label>
                                    <input class="form-control" type="text" name="cur_text" required
                                        value="{{ gs('cur_text') }}">
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency Symbol')</label>
                                    <input class="form-control" type="text" name="cur_sym" required
                                        value="{{ gs('cur_sym') }}">
                                </div>
                            </div>

                            <div class="form-group col-xl-4 col-sm-6">
                                <label> @lang('Timezone')</label>
                                <select class="select2 form-control" name="timezone">
                                    @foreach ($timezones as $key => $timezone)
                                        <option value="{{ @$key }}" @selected(@$key == $currentTimezone)>{{ __($timezone) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label> @lang('Site Base Color')</label>
                                    <div class="input-group">
                                        <span class="input-group-text p-0 border-0">
                                            <input type='text' class="form-control colorPicker"
                                                value="{{ gs('base_color') }}">
                                        </span>
                                        <input type="text" class="form-control colorCode" name="base_color"
                                            value="{{ gs('base_color') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label> @lang('Site Secondary Color')</label>
                                    <div class="input-group">
                                        <span class="input-group-text p-0 border-0">
                                            <input type='text' class="form-control colorPicker"
                                                value="{{ gs('secondary_color') }}">
                                        </span>
                                        <input type="text" class="form-control colorCode" name="secondary_color"
                                            value="{{ gs('secondary_color') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label> @lang('Record to Display Per page')</label>
                                    <select class="select2 form-control" name="paginate_number"
                                        data-minimum-results-for-search="-1">
                                        <option value="20" @selected(gs('paginate_number') == 20)>@lang('20 items per page')</option>
                                        <option value="50" @selected(gs('paginate_number') == 50)>@lang('50 items per page')</option>
                                        <option value="100" @selected(gs('paginate_number') == 100)>@lang('100 items per page')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6 ">
                                <div class="form-group">
                                    <label> @lang('Currency Showing Format')</label>
                                    <select class="select2 form-control" name="currency_format"
                                        data-minimum-results-for-search="-1">
                                        <option value="1" @selected(gs('currency_format') == Status::CUR_BOTH)>@lang('Show Currency Text and Symbol Both')</option>
                                        <option value="2" @selected(gs('currency_format') == Status::CUR_TEXT)>@lang('Show Currency Text Only')</option>
                                        <option value="3" @selected(gs('currency_format') == Status::CUR_SYM)>@lang('Show Currency Symbol Only')</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-xl-4 col-sm-6 ">
                                <div class="form-group">
                                    <label> @lang('Crypto Currency Api')
                                        <small class="text--small text--info instructionModal">
                                            <i class="las la-info-circle"></i>
                                            @lang('Instruction For Api')
                                        </small>
                                    </label>
                                    <input class="form-control" type="text" name="crypto_currency_api"
                                        value="{{ gs('crypto_currency_api') }}">
                                </div>
                            </div>


                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="showModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Instruction Of Crypto Currency API')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">@lang('Go to the CoinMarketCap website') <a
                                href="https://coinmarketcap.com/api" target="_blank">https://coinmarketcap.com/api</a>
                        </li>
                        <li class="list-group-item">@lang('Signup this platform or login existing account')</li>
                        <li class="list-group-item">@lang('After logging into your CoinMarketCap account, Choose an API Plan')</li>
                        <li class="list-group-item">@lang('Generate an API Key')</li>
                        <li class="list-group-item">@lang('Copy API key & configure here')</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection



@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";


            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });

            $(".instructionModal").on("click", function() {
                $("#showModal").modal("show");
            });
        })(jQuery);
    </script>
@endpush
