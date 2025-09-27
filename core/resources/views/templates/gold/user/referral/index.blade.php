@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <div class="form-group mb-4">
                <label class="d-flex justify-content-between">
                    <span class="form--label">@lang('Referral Link')</span>
                    @if (auth()->user()->referrer)
                        <span class="text--info form--label">@lang('You are referred by') {{ auth()->user()->referrer->fullname }}</span>
                    @endif
                </label>
                <div class="input-group">
                    <input class="form-control form--control referralURL" name="text" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly="">
                    <button class="input-group-text btn btn--base btn--sm copytext copyBoard" id="copyBoard"> <i class="fa fa-copy"></i> </button>
                </div>
            </div>
            @if ($user->allReferrals->count() > 0 && $maxLevel > 0)
                <label>@lang('My Referrals')</label>
                <div class="treeview-container">
                    <ul class="treeview">
                        <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                            @include($activeTemplate . 'partials.under_tree', ['user' => $user, 'layer' => 0, 'isFirst' => true])
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('style')
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
                notify('success', "Copied: " + copyText.value);
            });
        })(jQuery);
    </script>
@endpush
