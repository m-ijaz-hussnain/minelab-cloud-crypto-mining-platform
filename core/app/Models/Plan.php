<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use GlobalStatus;

    protected $guarded = ['id'];
    protected $hidden  = ['created_at', 'updated_at'];
    protected $casts   = [
        'features' => 'array',
    ];

    public function scopeActive($query)
    {
        $query->where('status', Status::ENABLE);
    }

    public function miner()
    {
        return $this->belongsTo(Miner::class);
    }

    public function getPeriodUnitTextAttribute()
    {
        switch ($this->period_unit) {
            case 2:
                return 'Year';
            case 1:
                return 'Month';

            default:
                return 'Day';
        }
    }

    public function getReturnPerDayAttribute()
    {
        if (!$this->max_return_per_day) {
            return showAmount($this->min_return_per_day, 8, exceptZeros: true, currencyFormat: false);
        } else {
            return showAmount($this->min_return_per_day, 8, exceptZeros: true, currencyFormat: false) . ' - ' . showAmount($this->max_return_per_day, 8, exceptZeros: true, currencyFormat: false);
        }
    }

    public function getSpeedUnitTextAttribute()
    {
        switch ($this->speed_unit) {
            case 8:
                return 'Year';
            case 7:
                return 'Zhash/s';
            case 6:
                return 'Ehash/s';
            case 5:
                return 'Phash/s';
            case 4:
                return 'Thash/s';
            case 3:
                return 'Ghash/s';
            case 2:
                return 'Mhash/s';
            case 1:
                return 'Khash/s';

            default:
                return 'hash/s';
        }
    }
}
