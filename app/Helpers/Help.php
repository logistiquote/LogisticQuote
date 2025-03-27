<?php

use Illuminate\Support\Facades\Http;

function getExchangeRateEURtoUSD(): float
{
    return cache()->remember('eur_to_usd_rate', now()->addHours(6), function () {
        $response = Http::get('https://api.exchangerate.host/latest', [
            'base' => 'EUR',
            'symbols' => 'USD',
        ]);

        return $response->json('rates.USD', 1);
    });
}

function convertEurToUsdWith1PercentFee(float $eur): float
{
    $rate = getExchangeRateEURtoUSD();
    $usd = $eur * $rate;
    $usdWithFee = $usd * 1.01; // Add 1% after conversion

    return round($usdWithFee, 2);
}
