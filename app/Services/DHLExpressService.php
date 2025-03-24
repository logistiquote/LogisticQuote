<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\DHLApiException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DHLExpressService
{
    protected Client $client;
    protected string $apiUrl;
    protected string $apiKey;
    protected string $apiSecret;
    protected string $exportAccountNumber;
    protected string $importAccountNumber;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('DHL_API_URL');
        $this->apiKey = env('DHL_API_KEY');
        $this->apiSecret = env('DHL_CLIENT_SECRET');
        $this->importAccountNumber = env('DHL_IMPORT_ACCOUNT_NUMBER');
        $this->exportAccountNumber = env('DHL_EXPORT_ACCOUNT_NUMBER');
    }

    public function getQuote($origin, $destination, $weight, $dimensions, $plannedShippingDateAndTime)
    {
        $accountNumber =  $origin['origin_country'] === 'IL' ? $this->exportAccountNumber : $this->importAccountNumber;
        try {
            Log::info("Requesting DHL quote", compact('origin', 'destination', 'weight', 'dimensions'));

            $response = $this->client->request('GET', "{$this->apiUrl}/rates", [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode("$this->apiKey:$this->apiSecret"),
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'accountNumber' => $accountNumber,
                    'originCountryCode' => $origin['origin_country'],
                    'originCityName' => $origin['origin_city'],
                    'originPostalCode' => $origin['origin_postal_code'],
                    'destinationCountryCode' => $destination['destination_country'],
                    'destinationCityName' => $destination['destination_city'],
                    'destinationPostalCode' => $destination['destination_postal_code'],
                    'weight' => (int)$weight,
                    'length' => (int)$dimensions['length'],
                    'width' => (int)$dimensions['width'],
                    'height' => (int)$dimensions['height'],
                    'plannedShippingDate' => $plannedShippingDateAndTime,
                    'isCustomsDeclarable' => 'true',
                    'unitOfMeasurement' => 'metric'
                ]
            ]);

            $rates = json_decode($response->getBody(), true);
            Session::put('dhl_rates', $rates);

            Log::info("DHL quote retrieved successfully", ['response' => $rates]);

            return $rates;

        } catch (RequestException $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 'No response';
            $body = $e->getResponse() ? json_decode($e->getResponse()->getBody()->getContents()) : 'No response';
            Log::error("DHL API Request Failed: " . $e->getMessage());
            throw new DHLApiException($body->detail, $statusCode);
        }
    }

    private function mockDHLResponse(): array
    {
        return [
            "products" => [
                [
                    "productCode" => "TDI9",
                    "productName" => "DHL Express 9:00 AM",
                    "totalPrice" => "35.00",
                    "currency" => "USD",
                    "deliveryTime" => "Next business day before 9:00 AM"
                ],
                [
                    "productCode" => "TDI12",
                    "productName" => "DHL Express 12:00 PM",
                    "totalPrice" => "25.00",
                    "currency" => "USD",
                    "deliveryTime" => "Next business day before 12:00 PM"
                ]
            ]
        ];
    }
}

