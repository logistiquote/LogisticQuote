<?php

namespace App\Services\Payment;

class StripePayment implements PaymentStrategy
{
    public function initialize(array $data)
    {
        echo "Initializing Stripe payment with data: " . json_encode($data) . "\n";
    }

    public function process(float $amount): bool
    {
        echo "Processing Stripe payment of $amount\n";
        return true;
    }

    public function confirm(): string
    {
        return "Stripe payment confirmed.";
    }
}
