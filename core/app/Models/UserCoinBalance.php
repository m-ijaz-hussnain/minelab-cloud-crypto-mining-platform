<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoinBalance extends Model
{
    protected $guarded = ['id'];


    public function miner()
    {
        return $this->belongsTo(Miner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
