<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{

    public function user() {
        $this->belongsTo(User::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id', 'id');
    }
}
