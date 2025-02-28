<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\DHLApiException;
use Illuminate\Support\Facades\Log;

class DHLShipmentService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;
    protected $accountNumber;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('DHL_API_URL');
        $this->apiKey = env('DHL_API_KEY');
        $this->accountNumber = env('DHL_ACCOUNT_NUMBER');
    }

    public function createShipment($shipmentDetails)
    {
        try {
            Log::info("Creating DHL shipment", $shipmentDetails);

            $response = $this->client->request('POST', "{$this->apiUrl}/shipments", [
                'headers' => [
                    'DHL-API-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'customerDetails' => [
                        'shipperDetails' => [
                            'postalCode' => $shipmentDetails['origin']['postal_code'],
                            'countryCode' => $shipmentDetails['origin']['country'],
                        ],
                        'receiverDetails' => [
                            'postalCode' => $shipmentDetails['destination']['postal_code'],
                            'countryCode' => $shipmentDetails['destination']['country'],
                        ]
                    ],
                    'accounts' => [
                        [
                            'typeCode' => 'shipper',
                            'number' => $this->accountNumber
                        ]
                    ],
                    'plannedShippingDateAndTime' => now()->toIso8601String(),
                    'productCode' => $shipmentDetails['service_type'],
                    'unitOfMeasurement' => 'metric',
                    'currencyCode' => 'USD',
                    'content' => 'Air shipment package',
                    'packages' => [
                        [
                            'weight' => $shipmentDetails['weight'],
                            'dimensions' => [
                                'length' => $shipmentDetails['dimensions']['length'],
                                'width' => $shipmentDetails['dimensions']['width'],
                                'height' => $shipmentDetails['dimensions']['height']
                            ]
                        ]
                    ]
                ]
            ]);

            return json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            Log::error("DHL Shipment Failed: " . $e->getMessage());
            throw new DHLApiException("Failed to create DHL shipment. Please try again later.", 502);
        }
    }
}


