<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDHLShipmentRequest;
use App\Services\DHLShipmentService;
use App\Models\Shipment;
use App\Services\QuotationService;
use Exception;
use Illuminate\Support\Facades\DB;

class DHLShipmentController extends Controller
{
    public function __construct(protected DHLShipmentService $dhlShipmentService, private QuotationService $quotationService)
    {
    }

    public function createShipment(CreateDHLShipmentRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $shipmentDetails = session('air_quote_data');

            if (!$shipmentDetails) {
                return redirect()->route('dhl.quote')->withErrors(['error' => 'No shipment details found. Please request a quote first.']);
            }
            $quotation = $this->quotationService->createQuotation([
                'type' => 'DHL',
                'transportation_type' => 'air',
                'ready_to_load_date' => $shipmentDetails['planned_shipping_date'],
            ]);

            $shipmentDetails = array_merge($shipmentDetails, $validated);

            $shipmentResponse = $this->dhlShipmentService->createShipment($shipmentDetails);

            if (isset($shipmentResponse['trackingUrl'], $shipmentResponse['shipmentTrackingNumber'])) {

                $matchedProduct = collect($shipmentDetails['products'])->first(function ($product) use ($shipmentDetails) {
                    return str_contains($product['productCode'], $shipmentDetails['service']);
                });

                $eurPrice = null;

                if ($matchedProduct) {
                    $eurPriceEntry = collect($matchedProduct['totalPrice'])->firstWhere('priceCurrency', 'EUR');
                    if ($eurPriceEntry) {
                        $eurPrice = $eurPriceEntry['price'];
                    }
                }
                unset($shipmentDetails['invoice_pdf']);
                unset($shipmentDetails['exchangeRates']);
                unset($shipmentDetails['products']);

                $shipment = Shipment::create([
                    'quotation_id' => $quotation->id,
                    'carrier' => 'DHL',
                    'service_type' => $shipmentDetails['service'],
                    'tracking_number' => $shipmentResponse['shipmentTrackingNumber'],
                    'tracking_url' => $shipmentResponse['trackingUrl'],
                    'label_url' => $shipmentResponse['label'] ?? null,
                    'shipment_data' => $shipmentDetails,
                ]);

                $quotation->update([
                    'total_price' => $eurPrice,
                    'value_of_goods' => $shipmentDetails['declared_value']
                ]);

                session()->forget([
                    'dhl_rates'
                ]);

                DB::commit();

                return redirect()->route('quotation.index')->with('success', 'Quotation created successfully!');
            }

            return redirect()->route('dhl.quote')->withErrors(['error' => 'Failed to create shipment.']);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('dhl.quote')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
