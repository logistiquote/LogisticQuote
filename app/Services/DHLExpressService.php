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
    protected string $accountNumber;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('DHL_API_URL');
        $this->apiKey = env('DHL_API_KEY');
        $this->accountNumber = env('DHL_ACCOUNT_NUMBER');
    }

    public function getQuote($origin, $destination, $weight, $dimensions, $plannedShippingDateAndTime)
    {

        if (app()->environment('local')) {
            return $this->mockDHLResponse();
        }

        try {
            Log::info("Requesting DHL quote", compact('origin', 'destination', 'weight', 'dimensions'));

            $response = $this->client->request('POST', "{$this->apiUrl}/rates", [
                'headers' => [
                    'DHL-API-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    "customerDetails" => [
                        "shipperDetails" => [
                            "postalCode" => $origin['postal_code'],
                            "cityName" => $origin['city'],
                            "countryCode" => $origin['country'],
                            "provinceCode" => $origin['province'] ?? null,
                            "addressLine1" => $origin['address_line1'] ?? "N/A",
                            "addressLine2" => $origin['address_line2'] ?? "",
                            "addressLine3" => $origin['address_line3'] ?? "",
                            "countyName" => $origin['county'] ?? "N/A"
                        ],
                        "receiverDetails" => [
                            "postalCode" => $destination['postal_code'],
                            "cityName" => $destination['city'],
                            "countryCode" => $destination['country'],
                            "provinceCode" => $destination['province'] ?? null,
                            "addressLine1" => $destination['address_line1'] ?? "N/A",
                            "addressLine2" => $destination['address_line2'] ?? "",
                            "addressLine3" => $destination['address_line3'] ?? "",
                            "countyName" => $destination['county'] ?? "N/A"
                        ]
                    ],
                    "accounts" => [
                        [
                            "typeCode" => "shipper",
                            "number" => $this->accountNumber
                        ]
                    ],
                    "productCode" => "P",
                    "localProductCode" => "P",
                    "valueAddedServices" => [
                        [
                            "serviceCode" => "II",
                            "localServiceCode" => "II",
                            "value" => 100,
                            "currency" => "GBP",
                            "method" => "cash"
                        ]
                    ],
                    "productsAndServices" => [
                        [
                            "productCode" => "P",
                            "localProductCode" => "P",
                            "valueAddedServices" => [
                                [
                                    "serviceCode" => "II",
                                    "localServiceCode" => "II",
                                    "value" => 100,
                                    "currency" => "GBP",
                                    "method" => "cash"
                                ]
                            ]
                        ]
                    ],
                    "payerCountryCode" => $origin['country'],
                    "plannedShippingDateAndTime" => $plannedShippingDateAndTime . "T12:00:00GMT+00:00",
                    "unitOfMeasurement" => "metric",
                    "isCustomsDeclarable" => false,
                    "monetaryAmount" => [
                        [
                            "typeCode" => "declaredValue",
                            "value" => 100,
                            "currency" => "CZK"
                        ]
                    ],
                    "requestAllValueAddedServices" => false,
                    "estimatedDeliveryDate" => [
                        "isRequested" => false,
                        "typeCode" => "QDDC"
                    ],
                    "getAdditionalInformation" => [
                        [
                            "typeCode" => "allValueAddedServices",
                            "isRequested" => true
                        ]
                    ],
                    "returnStandardProductsOnly" => false,
                    "nextBusinessDay" => false,
                    "productTypeCode" => "all",
                    "packages" => [
                        [
                            "typeCode" => "3BX",
                            "weight" => $weight,
                            "dimensions" => [
                                "length" => $dimensions['length'],
                                "width" => $dimensions['width'],
                                "height" => $dimensions['height']
                            ]
                        ]
                    ]
                ]
            ]);

            $rates = json_decode($response->getBody(), true);
            Session::put('dhl_rates', $rates);
            Session::put('dhl_shipment_details', compact('origin', 'destination', 'weight', 'dimensions'));

            Log::info("DHL quote retrieved successfully", ['response' => $rates]);

            return $rates;

        } catch (RequestException $e) {
            Log::error("DHL API Request Failed: " . $e->getMessage());
            throw new DHLApiException("Failed to retrieve DHL rates. Please try again later.", 502);
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

