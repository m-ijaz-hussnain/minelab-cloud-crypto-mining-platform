@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="profile-area">
                <form action="" class="profile-form" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="InputFirstname">@lang('First Name')</label>
                                <input class="form-control" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" required type="text" value="{{ $user->firstname }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="lastname">@lang('Last Name')</label>
                                <input class="form-control" id="lastname" name="lastname" placeholder="@lang('Last Name')" required type="text" value="{{ $user->lastname }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>@lang('Username')</label>
                                <input class="form-control" placeholder="Username" readonly type="text" value="{{ $user->username }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">@lang('E-mail Address')</label>
                                <input class="form-control" id="email" name="email" placeholder="@lang('E-mail Address')" readonly type="email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone">@lang('Mobile Number')</label>
                                <div class="input-group">
                                    <span class="input-group-text">+{{ $user->dial_code }}</span>
                                    <input class="form-control" id="phone" name="mobile" placeholder="@lang('Your Contact Number')" readonly type="tel" value="{{ $user->mobile }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="country">@lang('Country')</label>
                                <input class="form-control" id="country" readonly type="text" value="{{ $user->country_name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="address">@lang('Address')</label>
                                <input class="form-control" id="address" name="address" placeholder="@lang('Address')" required="" type="text" value="{{ $user->address }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="state">@lang('State')</label>
                                <input class="form-control" id="state" name="state" placeholder="@lang('state')" required="" type="text" value="{{ $user->state }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="zip">@lang('Zip Code')</label>
                                <input class="form-control" id="zip" name="zip" placeholder="@lang('Zip Code')" required="" type="text" value="{{ $user->zip }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="city">@lang('City')</label>
                                <input class="form-control" id="city" name="city" placeholder="@lang('City')" required="" type="text" value="{{ $user->city }}">
                            </div>
                        </div>

                    </div>
                    <button class="submit-btn" type="submit">@lang('Submit')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
