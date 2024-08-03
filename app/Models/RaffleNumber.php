<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'raffle_id',
        'order_id',
        'number',
    ];

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
