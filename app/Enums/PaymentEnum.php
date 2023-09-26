<?php

namespace App\Enums;

enum PaymentEnum: string
{
    case CARD = 'card';
    case CASH = 'cash';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
