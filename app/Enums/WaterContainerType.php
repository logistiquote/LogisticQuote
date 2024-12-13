<?php

namespace App\Enums;

enum WaterContainerType: string
{
    case TwentyDV = '20DV';
    case FortyDV = '40DV';
    case FortyHC = '40HC';

    public static function all(): array
    {
        return [
            self::TwentyDV->value,
            self::FortyDV->value,
            self::FortyHC->value,
        ];
    }
}
