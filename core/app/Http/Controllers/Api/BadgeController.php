<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;

class BadgeController extends Controller
{

    public function badge()
    {
        $user = auth()->user();

        $userBadges = UserBadge::with('badge')->where('user_id', $user->id)->orderBy('sequence_number')->get();
        $badges     = Badge::orderBy('earning_amount', 'asc')->get();

        $notify[] = 'Achievement Data';

        return response()->json([
            'remark'  => 'achievement_data',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'userBadges' => $userBadges,
                'badges'     => $badges,
                'badge_path' => getFilePath('badge'),
            ],
        ]);

    }
}
