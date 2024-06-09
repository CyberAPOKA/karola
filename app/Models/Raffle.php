<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Raffle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start',
        'end',
        'price_1_coupon',
        'price_100_coupons',
        'price_250_coupons',
        'price_500_coupons',
        'price_1000_coupons',
        'price_5000_coupons',
        'price_10000_coupons',
        'description',
        'image_path'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            do {
                $uuid = (string) Str::uuid();
            } while (self::where('uuid', $uuid)->exists());

            $model->uuid = $uuid;
        });
    }
}
