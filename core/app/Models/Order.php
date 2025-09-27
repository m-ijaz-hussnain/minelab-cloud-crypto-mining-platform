<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $guarded = ['id'];

    protected $casts = [
        'plan_details' => 'object',
    ];

    public function scopeApproved($query) {
        $query->where('status', Status::ORDER_APPROVED);
    }

    public function scopeUnpaid($query) {
        $query->where('status', Status::ORDER_UNPAID);
    }

    public function scopePending($query) {
        $query->where('status', Status::ORDER_PENDING);
    }

    public function scopeRejected($query) {
        $query->where('status', Status::ORDER_REJECT);
    }
    public function scopeRunning($query) {
        $query->where('status', Status::ORDER_APPROVED)->where('period_remain', '>', 0);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function deposit() {
        return $this->hasOne(Deposit::class);
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'trx', 'trx');
    }

    public function miner() {
        return $this->belongsTo(Miner::class);
    }

    public function statusBadge(): Attribute {
        return new Attribute(
            get: fn() => $this->badgeData(),
        );
    }

    public function badgeData() {
        if ($this->status == Status::ORDER_REJECT) {
            $class = 'danger';
            $data  = trans('Rejected');
        } elseif ($this->status == Status::ORDER_PENDING) {
            $class = 'warning';
            $data  = trans('Payment Pending');
        } elseif ($this->status == Status::ORDER_APPROVED) {
            $class = 'success';
            $data  = trans('Approved');
        } else {
            $class = 'dark';
            $data  = trans('Unpaid');
        }
        return '<span><span class="badge badge--' . $class . '">' . $data . '</span></span>';
    }
}
