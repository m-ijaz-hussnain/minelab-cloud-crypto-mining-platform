@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card custom--card">
                    <div class="card-body">
                        <form action="{{ route('user.kyc.submit') }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <x-viser-form checkboxClass='form--check' identifierValue="kyc" identifier="act" />

                            <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
