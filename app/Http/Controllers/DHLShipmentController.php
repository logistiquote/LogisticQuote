<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDHLShipmentRequest;
use App\Services\DHLShipmentService;
use App\Models\Quotation;
use App\Models\Shipment;
use App\Enums\DHLServiceType;
use App\Exceptions\DHLApiException;

class DHLShipmentController extends Controller
{
    public function __construct(protected DHLShipmentService $dhlShipmentService)
    {
    }

    public function createShipment(CreateDHLShipmentRequest $request)
    {
        $validated = $request->validated();
        try {
            $quotation = Quotation::findOrFail($validated['quotation_id']);
            $serviceType = DHLServiceType::from($validated['service_type']);

            $shipmentDetails = session('dhl_shipment_details');

            if (!$shipmentDetails) {
                return redirect()->route('dhl.quote')->withErrors(['error' => 'No shipment details found. Please request a quote first.']);
            }

            // Add selected service type to shipment request
            $shipmentDetails['service_type'] = $validated['service_type'];

            $shipmentResponse = $this->dhlShipmentService->createShipment($shipmentDetails);

            if (isset($shipmentResponse['shipmentID'], $shipmentResponse['trackingNumber'])) {
                $shipment = Shipment::create([
                    'quotation_id' => $quotation->id,
                    'carrier' => 'DHL',
                    'service_type' => $serviceType->value,
                    'tracking_number' => $shipmentResponse['trackingNumber'],
                    'label_url' => $shipmentResponse['label'] ?? null,
                    'shipment_id' => $shipmentResponse['shipmentID'],
                ]);

                session()->forget([
                    'dhl_shipment_details',
                    'dhl_rates'
                ]);

                return redirect()->route('dhl.tracking', ['tracking_number' => $shipment->tracking_number])
                    ->with('success', 'Shipment created successfully.');
            }

            return redirect()->route('dhl.quote')->withErrors(['error' => 'Failed to create shipment.']);
        } catch (DHLApiException $e) {
            return redirect()->route('dhl.quote')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
