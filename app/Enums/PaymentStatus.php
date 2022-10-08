<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case Completed = 1;
    case Declined = 2;
    case Reversed = 3;
    public static function status(string $status) {
        return constant('self::' . ucfirst($status));
    }
}
