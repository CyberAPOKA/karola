<?php

namespace App\Core\Constants;

use App\Core\Utils\Enum;

class StatusOrder extends Enum
{
    const PENDING = 'pending';
    const WAITING_PAYMENT = 'waiting_payment';
    const PAID = 'paid';
    const PENDING_REFUND = 'pending_refund';
    const REFUNDED = 'refunded';
    const WITH_ERROR = 'with_error';
    const FAILED = 'failed';

    static $labels = [
        self::PENDING => 'pending',
        self::WAITING_PAYMENT => 'waiting_payment',
        self::PAID => 'paid',
        self::PENDING_REFUND => 'pending_refund',
        self::REFUNDED => 'refunded',
        self::WITH_ERROR => 'with_error',
        self::FAILED => 'failed',
    ];
}
