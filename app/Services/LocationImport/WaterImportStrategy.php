<?php

namespace App\Services\LocationImport;

use App\Repositories\LocationRepository;
use App\Repositories\RouteRepository;

class WaterImportStrategy implements ImportStrategyInterface
{

    public function __construct(protected LocationRepository $locationRepository, protected RouteRepository $routeRepository)
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
//            $route = $this->routeRepository->createOrUpdate([
//                'origin_id' => $origin->id,
//                'destination_id' => $destination->id,
//                'type' => 'water',
//            ]);

//            $results[] = $route;
        }

        return $results;
    }
}

