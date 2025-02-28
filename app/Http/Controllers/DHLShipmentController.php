<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDHLShipmentRequest;
use App\Services\DHLShipmentService;
use App\Models\Quotation;
use App\Models\Shipment;
use App\Enums\DHLServiceType;
use App\Exceptions\DHLApiException;
use App\Services\QuotationService;
use Exception;
use Illuminate\Http\Request;
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

            $serviceType = DHLServiceType::from($validated['service_type']);

            $shipmentDetails['service_type'] = $validated['service_type'];

//            $shipmentResponse = $this->dhlShipmentService->createShipment($shipmentDetails);
            $shipmentResponse = [
                'shipmentID' => 'shipmentID-test',
                'trackingNumber' => 'trackingNumber-test'
            ];

            if (isset($shipmentResponse['shipmentID'], $shipmentResponse['trackingNumber'])) {
                $shipment = Shipment::create([
                    'quotation_id' => $quotation->id,
                    'carrier' => 'DHL',
                    'service_type' => $serviceType->value,
                    'tracking_number' => $shipmentResponse['trackingNumber'],
                    'label_url' => $shipmentResponse['label'] ?? null,
                    'shipment_id' => $shipmentResponse['shipmentID'],
                    'shipment_data' => $shipmentDetails,
                ]);

                session()->forget([
                    'dhl_rates'
                ]);

                DB::commit();

//                return redirect()->route('dhl.tracking', ['tracking_number' => $shipment->tracking_number])
//                    ->with('success', 'Shipment created successfully.');
                return redirect()->route('quotation.index')->with('success', 'Quotation created successfully!');
            }

            return redirect()->route('dhl.quote')->withErrors(['error' => 'Failed to create shipment.']);
        } catch (Exception $e) {
            DB::rollBack();

            dd($e->getMessage());
            return redirect()->route('dhl.quote')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
