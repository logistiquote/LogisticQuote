<?php

namespace App\Enums;

enum DHLServiceType: string
{
    case EXPRESS_WORLDWIDE = 'P';
    case EXPRESS_9AM = 'TDI9';
    case EXPRESS_10_30AM = 'TDI10:30';
    case EXPRESS_12PM = 'TDI12';
    case EXPRESS_ENVELOPE = 'X';
    case MEDICAL_EXPRESS = 'WMX';
    case JETLINE = 'JET';
    case SPRINTLINE = 'SPT';
    case EXPRESS_EASY = 'E';

    public function label(): string
    {
        return match ($this) {
            self::EXPRESS_WORLDWIDE => 'DHL Express Worldwide',
            self::EXPRESS_9AM => 'DHL Express 9:00 AM',
            self::EXPRESS_10_30AM => 'DHL Express 10:30 AM',
            self::EXPRESS_12PM => 'DHL Express 12:00 PM',
            self::EXPRESS_ENVELOPE => 'DHL Express Envelope',
            self::MEDICAL_EXPRESS => 'DHL Medical Express',
            self::JETLINE => 'DHL Jetline',
            self::SPRINTLINE => 'DHL Sprintline',
            self::EXPRESS_EASY => 'DHL Express Easy',
        };
    }
}

