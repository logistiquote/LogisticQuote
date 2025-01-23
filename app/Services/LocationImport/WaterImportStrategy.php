<?php

namespace App\Services\LocationImport;

use App\Enums\WaterContainerType;
use App\Repositories\LocationRepository;
use App\Repositories\RouteContainerRepository;
use App\Repositories\RouteRepository;

class WaterImportStrategy implements ImportStrategyInterface
{

    public function __construct(
        protected LocationRepository       $locationRepository,
        protected RouteRepository          $routeRepository,
        protected RouteContainerRepository $routeContainerRepository
    )
    {
    }

    public function import(string $filePath): array
    {
        $data = array_map('str_getcsv', file($filePath));
        $header = array_map(function ($key) {
            return strtolower(str_replace(' ', '_', $key));
        }, array_shift($data));
        $results = [];

        foreach ($data as $row) {
            $record = array_combine($header, $row);

            // Add POL (Port of Loading) location
            $origin = $this->locationRepository->createOrUpdate([
                'country' => $record['country'],
                'country_code' => $record['country_code'],
                'name' => $record['pol'],
                'type' => 'water',
            ]);

            // Add POD (Port of Destination) location
            $destination = $this->locationRepository->createOrUpdate([
                'country' => 'Israel',
                'country_code' => 'IL',
                'name' => $record['pod'],
                'type' => 'water',
            ]);

            // Add route
            $route = $this->routeRepository->createOrUpdate([
                'origin_id' => $origin->id,
                'destination_id' => $destination->id,
                'type' => 'water',
                'delivery_line' => $record['shipping_line'],
                'delivery_time' => $record['transit_time'],
            ]);

            foreach (WaterContainerType::all() as $containerType) {
                $priceField = strtolower($containerType);
                $this->routeContainerRepository->createOrUpdate([
                    'route_id' => $route->id,
                    'container_type' => $containerType,
                    'price' => isset($record[$priceField]) ? (float)$record[$priceField] : 0.00,
                ]);
            }

            $results[] = $route;
        }

        return $results;
    }
}

