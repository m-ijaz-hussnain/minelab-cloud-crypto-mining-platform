<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;

class BadgeController extends Controller
{
    public function badge()
    {
        $pageTitle = 'Achievements';
        $user      = auth()->user();

        $userBadges = UserBadge::where('user_id', $user->id)->orderBy('sequence_number', 'DESC')->get();
        $badges     = Badge::orderBy('earning_amount', 'asc')->get();

        return view('Template::user.badge', compact('pageTitle', 'user', 'userBadges', 'badges'));
    }
}
