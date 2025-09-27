@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card custom--card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="d-flex justify-content-between">
                            <span>@lang('Referral Link')</span>
                            @if (auth()->user()->referrer)
                                <span class="text-info">@lang('You are referred by') {{ auth()->user()->referrer->fullname }}</span>
                            @endif
                        </label>
                        <div class="input-group">
                            <input class="form-control form-control-lg referralURL text-muted ps-3" name="text" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly="">
                            <button class="input-group-text copyBoard" id="copyBoard"> <i class="la la-copy"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($user->allReferrals->count() > 0 && $maxLevel > 0)
        <div class="order-section pd-t-30 pd-b-80">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-12 mrb-30">
                    <label>@lang('My Referees')</label>
                    <div class="treeview-container">
                        <ul class="treeview">
                            <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                                @include($activeTemplate . 'partials.under_tree', ['user' => $user, 'layer' => 0, 'isFirst' => true])
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('style-lib')
    <link type="text/css" href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
    <script>
        (function($) {
            "use strict";

            $('.treeview').treeView();
            $('.copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                notify('success', "Copied");
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .input-group input {
            padding-left: 15px !important;
        }
    </style>
@endpush
