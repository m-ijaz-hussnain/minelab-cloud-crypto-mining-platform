@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('KYC Documents')</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.kyc.submit') }}" enctype="multipart/form-data" method="post">
                        @csrf

                        <x-viser-form identifierValue="kyc" identifier="act" />
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
