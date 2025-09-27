<div class="dashboard-sidebar-menu">
    <div class="dashboard-sidebar__close d-lg-none d-block">
        <span class="dashboard-sidebar__close-icon">
            <i class="las la-times"></i>
        </span>
    </div>
    <ul class="dashboard-menu">
        <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.home') }}" href="{{ route('user.home') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-home"></i> </span> @lang('Dashboard') </a></li>

        <li class="dashboard-menu__item has-submenu">
            <a class="dashboard-menu__link {{ menuActive('user.plan*') }}" href="javascript:void(0)"><span class="dashboard-menu__link-icon"> <i class="las la-clipboard-list"></i> </span> @lang('Mining') <span class="dashboard-menu__link-arrow"> <i class="las la-angle-right"></i> </span> </a>
            <ul class="sub-menu dashboard-menu">
                <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.plans') }}" href="{{ route('user.plans') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-shopping-cart"></i> </span> @lang('Start Mining')</a></li>

                <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.plans.purchased') }}" href="{{ route('user.plans.purchased') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-credit-card"></i></span> @lang('Mining Tracks')</a></li>
            </ul>
        </li>

        @if (gs('referral_system'))
            <li class="dashboard-menu__item has-submenu">
                <a class="dashboard-menu__link {{ menuActive('user.referral*') }}" href="javascript:void(0)"> <span class="dashboard-menu__link-icon"> <i class="las la-user-check"></i> </span> @lang('Referral') <span class="dashboard-menu__link-arrow"> <i class="las la-angle-right"></i> </span> </a>
                <ul class="sub-menu dashboard-menu">
                    <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.referral') }}" href="{{ route('user.referral') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-users"></i> </span> @lang('My Referrals')</a></li>
                    <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.referral.log') }}" href="{{ route('user.referral.log') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-list"></i> </span> @lang('Referral Bonus Logs')</a></li>
                </ul>
            </li>
        @endif

        <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.wallets') }}" href="{{ route('user.wallets') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-wallet"></i> </span> @lang('Wallets')</a></li>

        <li class="dashboard-menu__item has-submenu">
            <a class="dashboard-menu__link {{ menuActive('user.withdraw*') }}" href="javascript:void(0)"> <span class="dashboard-menu__link-icon"> <i class="las la-hand-holding-usd"></i></span> @lang('Widthdraw') <span class="dashboard-menu__link-arrow"> <i class="las la-angle-right"></i> </span></a>
            <ul class="sub-menu dashboard-menu">
                <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.withdraw') }}" href="{{ route('user.withdraw') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-minus-circle"></i> </span> @lang('Withdraw Now')</a></li>
                <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.withdraw.history') }}" href="{{ route('user.withdraw.history') }}"> <span class="dashboard-menu__link-icon"><i class="las la-list"></i> </span> @lang('My Withdrawals')</a></li>
            </ul>
        </li>


        <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.payment.history') }}" href="{{ route('user.payment.history') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-file-invoice-dollar"></i> </span> @lang('Payments Log')</a></li>

        <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.transactions') }}" href="{{ route('user.transactions') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-money-bill"></i> </span> @lang('Transactions')</a></li>

        <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.profile.setting') }}" href="{{ route('user.profile.setting') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-user"></i> </span> @lang('Profile Setting')</a></li>

        <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.change.password') }}" href="{{ route('user.change.password') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-key"></i> </span>@lang('Change Password')</a></li>

        <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('user.twofactor') }}" href="{{ route('user.twofactor') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-lock"></i> </span> @lang('2FA Security')</a></li>

        <li class="dashboard-menu__item has-submenu">
            <a class="dashboard-menu__link {{ menuActive('ticket*') }}" href="javascript:void(0)"> <span class="dashboard-menu__link-icon"> <i class="las la-ticket-alt"></i> </span> @lang('Support') <span class="dashboard-menu__link-arrow"> <i class="las la-angle-right"></i> </span> </a>
            <ul class="sub-menu dashboard-menu">
                <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive('ticket.open') }}" href="{{ route('ticket.open') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-plus-circle"></i> </span> @lang('Open Ticket')</a></li>

                <li class="dashboard-menu__item"><a class="dashboard-menu__link {{ menuActive(['ticket.index', 'ticket.view']) }}" href="{{ route('ticket.index') }}"> <span class="dashboard-menu__link-icon"> <i class="las la-list"></i> </span> @lang('All Tickets')</a></li>
            </ul>
        </li>
    </ul>
</div>
