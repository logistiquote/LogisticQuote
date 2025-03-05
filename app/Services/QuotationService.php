<?php

namespace App\Services;

use App\Enums\QuotationStatus;
use App\Models\Quotation;
use App\Models\RouteRate;
use App\Repositories\QuotationRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

class QuotationService
{
    public function __construct(private QuotationRepository $quotationRepository)
    {
    }

    public function createQuotation(array $data): Quotation
    {
        $baseQuotationData = $this->prepareBaseQuotationData($data);

        $quotation = $this->quotationRepository->createBaseQuotation($baseQuotationData);

        $totalPrice = 0;
        if (($data['transportation_type'] === 'ocean' || $data['transportation_type'] === 'sea') && $data['type'] === 'fcl') {
            $containers = $this->addContainers($quotation, $data);
            $totalPrice = $this->getGoodsTotalPrice($containers);
        }

        if (isset($data['calculate_by']) && $data['type'] === 'lcl') {
            if (!$quotation->route->rate) {
                throw new Exception('No route rates found for this quotation.');
            }
            $pallets = $this->addPallets($quotation, $data);
            $totalPrice = $this->getGoodsTotalPrice($pallets);

        }

        if (isset($data['attachment_file'])) {
            Storage::disk('public')->move('temp/' . $data['attachment_file'], 'files/' . $data['attachment_file']);

            $quotation->attachment = $data['attachment_file'];
        }
        $destinationCharges = $quotation->type === 'lcl' ? $quotation->route?->rate?->destination_charges : 0;
        $quotation->total_price = $totalPrice + $quotation->insurance_price + $destinationCharges;
        $quotation->save();

        return $quotation;
    }

    public function updateQuotation($id, array $data): Quotation
    {
        $quotation = $this->quotationRepository->findById($id);

        $baseQuotationData = [
            'transportation_type' => $data['transportation_type'],
            'type' => $data['type'],
            'value_of_goods' => $data['value_of_goods'],
        ];

        $this->quotationRepository->update($id, $baseQuotationData);

        $totalPrice = $quotation->total_price;
        if (($data['transportation_type'] === 'ocean' || $data['transportation_type'] === 'sea') && $data['type'] === 'fcl') {
            $data['route_containers'] = $quotation->route->containers;
            $containers = $this->updateContainers($quotation, $data);
            $totalPrice = $this->getGoodsTotalPrice($containers);
        }

        if (isset($data['calculate_by']) && $data['type'] === 'lcl') {
            $pallets = $this->addPallets($quotation, $data);
        }

        $quotation->total_price = $totalPrice;
        $quotation->save();

        return $quotation;
    }

    public function generateQuotationNumber(): string
    {
        $date = date('Ymd');

        $uniqueId = strtoupper(substr(uniqid(), -5));

        return "QUOTE-{$date}-{$uniqueId}";
    }

    /**
     * @throws Exception
     */
    public function withdrawQuotation($id): void
    {
        $quotation = $this->quotationRepository->findById($id);

        if (!$quotation) {
            throw new Exception("Quotation not found for ID: $id");
        }

        $this->quotationRepository->update($id, ['status' => 'withdrawn']);
    }

    private function prepareBaseQuotationData(array $data): array
    {
        $baseQuotationData = [
            'user_id' => auth()->id(),
            'route_id' => $data['route_id'] ?? null,
            'quote_number' => $this->generateQuotationNumber(),
            'status' => QuotationStatus::PENDING_PAYMENT,
            'type' => $data['type'],
            'transportation_type' => $data['transportation_type'],
            'ready_to_load_date' => Carbon::createFromFormat('Y-m-d', $data['ready_to_load_date']),
            'incoterms' => $data['incoterms'] ?? null,
            'pickup_address' => $data['pickup_address'] ?? null,
            'destination_address' => $data['final_destination_address'] ?? null,
            'value_of_goods' => $data['value_of_goods'] ?? null,
            'description_of_goods' => $data['description_of_goods'] ?? null,
            'is_stockable' => $data['isStockable'] ?? false,
            'is_dgr' => $data['isDgr'] ?? false,
            'is_clearance_req' => $data['isClearanceReq'] ?? false,
            'insurance' => $data['insurance'] ?? false,
            'insurance_price' => $this->calculateInsurancePrice($data['value_of_goods'] ?? 0),
            'remarks' => $data['remarks'] ?? null,
        ];

        if (isset($data['attachment']) && !empty(get_object_vars($data['attachment']))) {
            $fileName = rand() . '.' . $data['attachment']->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('files/', $data['attachment'], $fileName);
            $baseQuotationData['attachment'] = $fileName;
        }

        return $baseQuotationData;
    }

    public function calculateInsurancePrice($goodsValue)
    {
        $baseFee = $goodsValue * 1.1 * 0.003;

        return max($baseFee, 50);
    }

    private function addContainers(Quotation $quotation, array $data): array
    {
        $containers = $this->getFormatedContainersData($data);

        $this->quotationRepository->syncContainers($quotation, $containers);

        return $containers;
    }


    private function addPallets(Quotation $quotation, array $data): array
    {
        $pallets = [];

        if ($data['calculate_by'] === 'units') {
            foreach ($data['units'] as $unit) {
                $volumetricWeight = ($unit['l'] * $unit['w'] * $unit['h']) / 1000000;
                $pallets[] = [
                    'length' => $unit['l'],
                    'width' => $unit['w'],
                    'height' => $unit['h'],
                    'volumetric_weight' => $volumetricWeight,
                    'gross_weight' => $unit['gross_weight'],
                    'price' => $this->calculatePalletPrice(
                        max($volumetricWeight, ($unit['gross_weight'] / 1000)),
                        $quotation->route->rate
                    ),
                ];
            }

        } elseif ($data['calculate_by'] === 'shipment') {
            foreach ($data['shipment'] as $shipment) {
                $pallets[] = [
                    'volumetric_weight' => $shipment['volumetric_weight'],
                    'gross_weight' => $shipment['gross_weight'],
                    'quantity' => $shipment['quantity'],
                    'price' => $this->calculatePalletPrice(
                        max($shipment['volumetric_weight'], ($shipment['gross_weight'] / 1000)),
                        $quotation->route->rate
                    ) * $shipment['quantity'],
                ];
            }
        }

        $this->quotationRepository->syncPallets($quotation, $pallets);

        return $pallets;
    }

    public function getFormatedContainersData(array $data): array
    {
        $containers = [];
        $routeContainers = json_decode($data['route_containers']) ?? [];

        foreach ($data['container_size'] as $key => $size) {
            $container = current(array_filter($routeContainers, function ($item) use ($size) {
                return $item->container_type == $size;
            }));

            $containers[] = [
                'container_id' => $container->id,
                'size' => $size,
                'price' => $data['container_price'][$key] ?? $container->price,
                'weight' => $data['container_weight'][$key],
            ];
        }
        return $containers;
    }

    private function calculatePalletPrice($value, RouteRate $routeRate)
    {
        $price = $value * $routeRate->total_price;
        return round(max($price, $routeRate->min_ocean_freight), 2);
    }

    public function getGoodsTotalPrice(array $data): float
    {
        $totalPrice = 0;
        if (!empty($data)) {
            foreach ($data as $item) {
                $totalPrice += $item['price'];
            }
        }
        return $totalPrice;
    }

    private function updateContainers(Quotation $quotation, array $data): array
    {
        return $this->addContainers($quotation, $data);
    }

    private function updatePallets(Quotation $quotation, array $data): void
    {
        $this->addPallets($quotation, $data);
    }
}
