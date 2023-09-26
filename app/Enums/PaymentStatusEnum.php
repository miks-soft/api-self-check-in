<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case NEW = 'new';
    case ERROR = 'error';
    case SUCCESSFUL = 'successful';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
