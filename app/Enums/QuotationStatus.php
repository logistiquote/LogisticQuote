<?php

namespace App\Enums;

enum QuotationStatus: string
{
    case ACTIVE = 'active';
    case PENDING_PAYMENT = 'pending_payment';
    case PAID = 'paid';
    case DECLINED = 'declined';
    case EXPIRED = 'expired';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
