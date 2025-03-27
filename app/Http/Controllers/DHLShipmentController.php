<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDHLShipmentRequest;
use App\Mail\ShipmentLabelMail;
use App\Services\DHLShipmentService;
use App\Models\Shipment;
use App\Services\QuotationService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

            $shipmentDetails = array_merge($shipmentDetails, $validated);

            $quotation = $this->quotationService->createQuotation([
                'type' => 'DHL',
                'transportation_type' => 'air',
                'value_of_goods' => $shipmentDetails['declared_value'],
                'ready_to_load_date' => $shipmentDetails['planned_shipping_date'],
            ]);


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
                    $usdFinal = convertEurToUsdWith1PercentFee($eurPrice);

                    $product['productName'] = $matchedProduct['productName'];
                    $product['productCode'] = $matchedProduct['productCode'];
                    $product['eurPriceEntry'] = $eurPriceEntry;
                    $product['usdPrice'] = $usdFinal;
                    $product['pricingDate'] = $matchedProduct['pricingDate'];

                    $shipmentDetails['product'] = $product;
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
                    'shipment_data' => $shipmentDetails,
                ]);

                $quotation->update([
                    'total_price' => $quotation->total_price + $usdFinal * 1.1,
                ]);

                session()->forget([
                    'dhl_rates'
                ]);

                DB::commit();

                if (env('MAIL_ENABLED', false)) {
                    $document = collect($shipmentResponse['documents'])->firstWhere('typeCode', 'label');

                    $fileContent = base64_decode($document['content']);
                    $fileName = 'shipment-label.pdf';

                    Mail::to($quotation->user->email)->send(new ShipmentLabelMail($fileContent, $fileName, $quotation->user->name, $shipmentResponse['shipmentTrackingNumber']));
                }

                return redirect()->route('quotation.index')->with('success', 'Quotation created successfully!');
            }

            return redirect()->route('dhl.quote')->withErrors(['error' => 'Failed to create shipment.']);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('dhl.quote')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
