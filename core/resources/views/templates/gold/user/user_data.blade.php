@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.data.submit') }}">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <input class="form--control" name="username" type="text" value="{{ old('username') }}" placeholder="@lang('Username')" required>
                                        <small class="text--danger usernameExist"></small>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="country" class="form-control form--control select2" required>
                                                <option value="" selected disabled data-mobile_code="00">@lang('Select Country')</option>
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group ">
                                                <span class="input-group-text mobile-code">

                                                </span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile') }}" placeholder="@lang('Mobile')" class="form-control form--control checkUser" required>
                                            </div>
                                            <small class="text--danger mobileExist"></small>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <input class="form--control" name="address" type="text" value="{{ old('address') }}" placeholder="@lang('Address')">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form--control" name="state" type="text" value="{{ old('state') }}" placeholder="@lang('State')">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form--control" name="zip" type="text" value="{{ old('zip') }}" placeholder="@lang('Zip')">
                                    </div>

                                    <div class="col-sm-6">
                                        <input class="form--control" name="city" type="text" value="{{ old('city') }}" placeholder="@lang('City')">
                                    </div>

                                    <div>
                                        <button class="btn btn--base w-100" type="submit">
                                            @lang('Submit')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif
            $('.select2').select2();

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
