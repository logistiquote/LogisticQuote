<?php

namespace App\Enums;

enum WaterContainerType: string
{
    case TwentyDV = '20DV';
    case FortyDV = '40DV';
    case FortyHC = '40HC';
    case FortyRH = '40RH';
    case FortyFlat = '40 FLAT';
    case FortyFiveOT = '45OT';

    public static function all(): array
    {
        return [
            self::TwentyDV->value,
            self::FortyDV->value,
            self::FortyHC->value,
            self::FortyRH->value,
            self::FortyFlat->value,
            self::FortyFiveOT->value,
        ];
    }

    public static function custom(): array
    {
        return [
            self::FortyRH->value,
            self::FortyFlat->value,
            self::FortyFiveOT->value,
        ];
    }
}
