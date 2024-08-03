<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'raffle_id',
        'status',
        'total_coupons',
        'total_price',
        'qr_code_url',
        'qr_code',
        'amount_1_coupon',
        'amount_100_coupons',
        'amount_250_coupons',
        'amount_500_coupons',
        'amount_1000_coupons',
        'amount_5000_coupons',
        'amount_10000_coupons',
        'order_id',
        'code',
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }
}
