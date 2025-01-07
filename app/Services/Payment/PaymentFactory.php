<?php

namespace App\Services\Payment;

use Exception;

class PaymentFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $provider): PaymentStrategy
    {
        return match ($provider) {
            'paypal' => new PayPalPayment(),
            'stripe' => new StripePayment(),
            default => throw new Exception("Payment provider '$provider' not supported."),
        };
    }
}

