<?php

namespace App\Services;

use App\Models\Quotation;
use App\Repositories\QuotationRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

class QuotationService
{
    private QuotationRepository $quotationRepository;

    public function __construct(QuotationRepository $quotationRepository)
    {
        $this->quotationRepository = $quotationRepository;
    }

    public function createQuotation(array $data): Quotation
    {
        $baseQuotationData = $this->prepareBaseQuotationData($data);

        $quotation = $this->quotationRepository->createBaseQuotation($baseQuotationData);

        if ($data['transportation_type'] === 'ocean' && $data['type'] === 'fcl') {
            $this->addContainers($quotation, $data);
        }

        if ($data['calculate_by'] === 'units') {
            $this->addPallets($quotation, $data);
        } else {
            $quotation->update([
                'quantity' => $data['quantity'],
                'total_weight' => $data['total_weight'],
            ]);
        }

        return $quotation;
    }

    public function updateQuotation($id, array $data): Quotation
    {
        $quotation = $this->quotationRepository->findById($id);

        $baseQuotationData = $this->prepareBaseQuotationData($data);

        $this->quotationRepository->update($id, $baseQuotationData);

        if ($data['transportation_type'] === 'ocean' && $data['type'] === 'fcl') {
            $this->updateContainers($quotation, $data);
        }

        if ($data['calculate_by'] === 'units') {
            $this->updatePallets($quotation, $data);
        } else {
            $this->quotationRepository->update($id, [
                'quantity' => $data['quantity'],
                'total_weight' => $data['total_weight'],
            ]);
        }

        return $quotation;
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
//            'route_id' => $data['route_id'],
            'route_id' => 75,
            'status' => 'active',
            'type' => $data['type'],
            'transportation_type' => $data['transportation_type'],
            'ready_to_load_date' => Carbon::createFromFormat('Y-m-d', $data['ready_to_load_date']),
            'incoterms' => $data['incoterms'],
            'pickup_address' => $data['pickup_address'] ?? null,
            'destination_address' => $data['destination_address'] ?? null,
            'value_of_goods' => $data['value_of_goods'],
            'description_of_goods' => $data['description_of_goods'],
            'is_stockable' => $data['is_stockable'] ?? false,
            'is_dgr' => $data['is_dgr'] ?? false,
            'is_clearance_req' => $data['is_clearance_req'] ?? false,
            'insurance' => $data['insurance'] ?? false,
            'remarks' => $data['remarks'] ?? null,
        ];

        if (isset($data['attachment'])) {
            $fileName = rand() . '.' . $data['attachment']->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('files/', $data['attachment'], $fileName);
            $baseQuotationData['attachment'] = $fileName;
        }

        return $baseQuotationData;
    }

    private function addContainers(Quotation $quotation, array $data): void
    {
        $containers = [];
        foreach ($data['container_size'] as $key => $size) {
            $containers[] = [
                'container_no' => $key + 1,
                'size' => $size,
                'weight' => $data['container_weight'][$key],
            ];
        }

        $this->quotationRepository->syncContainers($quotation, $containers);
    }

    private function addPallets(Quotation $quotation, array $data): void
    {
        $pallets = [];
        $totalWeight = 0;

        foreach ($data['l'] as $key => $length) {
            $volumetricWeight = ($length * $data['w'][$key] * $data['h'][$key]) / 6000;
            $pallets[] = [
                'length' => $length,
                'width' => $data['w'][$key],
                'height' => $data['h'][$key],
                'volumetric_weight' => $volumetricWeight,
                'gross_weight' => $data['gross_weight'][$key],
            ];
            $totalWeight += $volumetricWeight;
        }

        $this->quotationRepository->syncPallets($quotation, $pallets);

        $quotation->update([
            'quantity' => count($pallets),
            'total_weight' => number_format($totalWeight, 2),
        ]);
    }

    private function updateContainers(Quotation $quotation, array $data): void
    {
        $this->addContainers($quotation, $data);
    }

    private function updatePallets(Quotation $quotation, array $data): void
    {
        $this->addPallets($quotation, $data);
    }
}