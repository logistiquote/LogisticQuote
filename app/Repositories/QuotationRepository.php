<?php

namespace App\Repositories;

use App\Models\Quotation;
use App\Models\QuotationContainer;
use App\Models\QuotationPallet;

class QuotationRepository
{
    public function createBaseQuotation(array $data): Quotation
    {
        $quotation = new Quotation($data);
        $quotation->save();

        return $quotation;
    }

    public function findById($id): Quotation
    {
        return Quotation::with(['containers', 'pallets'])->findOrFail($id);
    }

    public function update($id, array $data): Quotation
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update($data);
        return $quotation;
    }

    public function delete($id): void
    {
        Quotation::findOrFail($id)->delete();
    }

    public function addContainer(Quotation $quotation, array $containerData): QuotationContainer
    {
        $container = new QuotationContainer($containerData);
        $container->quotation_id = $quotation->id;
        $pricePerContainer = $containerData['price'];
        $container->total_price = $pricePerContainer;
        $container->quantity = 1;
        $container->weight = $containerData['weight'];
        $container->price_per_container = $pricePerContainer;
        $container->route_container_id = $containerData['container_id'];
        $container->save();

        return $container;
    }

    public function syncContainers(Quotation $quotation, array $containers): void
    {
        $quotation->containers()->delete();
        foreach ($containers as $container) {
            $this->addContainer($quotation, $container);
        }
    }

    public function addPallet(Quotation $quotation, array $palletData): QuotationPallet
    {
        $pallet = new QuotationPallet($palletData);
        $pallet->quotation_id = $quotation->id;
        $pallet->save();

        return $pallet;
    }

    public function syncPallets(Quotation $quotation, array $pallets): void
    {
        $quotation->pallets()->delete();
        foreach ($pallets as $pallet) {
            $this->addPallet($quotation, $pallet);
        }
    }
}



