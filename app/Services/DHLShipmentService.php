<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\DHLApiException;
use Illuminate\Support\Facades\Log;

class DHLShipmentService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;
    protected $apiSecret;
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

    public function createShipment($shipmentDetails)
    {
        $accountNumber = $shipmentDetails['origin_country'] === 'IL' ? $this->exportAccountNumber : $this->importAccountNumber;

        $exportDeclaration = [
            'lineItems' => array_map(function ($item, $index) {
                return [
                    'number' => $index + 1,
                    'description' => $item['description'],
                    'price' => (float) $item['price'],
                    'quantity' => [
                        'value' => (int) $item['quantity']['value'],
                        'unitOfMeasurement' => $item['quantity']['unitOfMeasurement'],
                    ],
                    'manufacturerCountry' => $item['manufacturerCountry'],
                    'weight' => [
                        'netValue' => (float) $item['weight']['netValue'],
                        'grossValue' => (float) $item['weight']['grossValue'],
                    ],
                ];
            }, $shipmentDetails['lineItems'], array_keys($shipmentDetails['lineItems'])),

            'invoice' => [
                'number' => $shipmentDetails['invoice']['number'],
                'date' => $shipmentDetails['invoice']['date'],
            ],
        ];

        try {
            Log::info("Creating DHL shipment", $shipmentDetails);

            $response = $this->client->request('POST', "{$this->apiUrl}/shipments", [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode("$this->apiKey:$this->apiSecret"),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'plannedShippingDateAndTime' => Carbon::parse($shipmentDetails['planned_shipping_date'])->format('Y-m-d\T00:00:00') . ' GMT+00:00',
                    'pickup' => [
                        'isRequested' => false,
                    ],
                    'productCode' => $shipmentDetails['service'],
                    'accounts' => [
                        [
                            'typeCode' => 'shipper',
                            'number' => $accountNumber
                        ]
                    ],
                    'documentImages' => [
                        [
                            'imageFormat' => 'PDF',
                            'typeCode' => 'INV',
                            'content' => base64_encode(file_get_contents($shipmentDetails['invoice_pdf']))
                        ]
                    ],
                    'customerDetails' => [
                        'shipperDetails' => [
                            'postalAddress' => [
                                'cityName' => $shipmentDetails['origin_city'],
                                'countryCode' => $shipmentDetails['origin_country'],
                                'postalCode' => $shipmentDetails['origin_postal_code'],
                                'addressLine1' => $shipmentDetails['origin_address_line1'],
                            ],
                            'contactInformation' => [
                                'email' => $shipmentDetails['origin_contact_email'],
                                'phone' => $shipmentDetails['origin_contact_phone'],
                                'fullName' => $shipmentDetails['origin_full_name'],
                                'companyName' => $shipmentDetails['origin_company_name'],
                            ],
                        ],
                        'receiverDetails' => [
                            'postalAddress' => [
                                'cityName' => $shipmentDetails['destination_city'],
                                'countryCode' => $shipmentDetails['destination_country'],
                                'postalCode' => $shipmentDetails['destination_postal_code'],
                                'addressLine1' => $shipmentDetails['destination_address_line1'],
                            ],
                            'contactInformation' => [
                                'email' => $shipmentDetails['destination_contact_email'],
                                'phone' => $shipmentDetails['destination_contact_phone'],
                                'fullName' => $shipmentDetails['destination_full_name'],
                                'companyName' => $shipmentDetails['destination_company_name'],
                            ],
                        ]
                    ],
                    'content' => [
                        'unitOfMeasurement' => 'metric',
                        'isCustomsDeclarable' => true,
                        'packages' => [
                            [
                                'weight' => (int)$shipmentDetails['weight'],
                                'dimensions' => [
                                    'length' => (int)$shipmentDetails['length'],
                                    'width' => (int)$shipmentDetails['width'],
                                    'height' => (int)$shipmentDetails['height']
                                ],
                            ]
                        ],
                        'exportDeclaration' => $exportDeclaration,
                        'description' => $shipmentDetails['description'],
                        'declaredValue' => (int)$shipmentDetails['declared_value'],
                        'declaredValueCurrency' => $shipmentDetails['declared_value_currency'],
                        'incoterm' => 'DAP'
                    ],
                ]
            ]);

            return json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            Log::error("DHL Shipment Failed: " . $e->getMessage());

            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body = $e->getResponse()
                ? json_decode($e->getResponse()->getBody()->getContents())
                : 'Failed to create DHL shipment. Please try again later.';

            throw new DHLApiException($body, $statusCode);
        }
    }
}


