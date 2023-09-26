<?php

namespace App\Enums;

enum AgeEnum: string
{
    case ADULT = 'adult';
    case CHILD = 'child';
    case INFANT = 'infant';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
