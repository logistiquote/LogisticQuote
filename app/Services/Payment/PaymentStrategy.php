<?php

namespace App\Services\Payment;

interface PaymentStrategy
{
    public function initialize(array $data);
}
