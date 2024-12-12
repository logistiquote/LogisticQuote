<?php

namespace App\Services\LocationImport;

use App\Repositories\LocationRepository;
use App\Repositories\RouteRepository;

class AirImportStrategy implements ImportStrategyInterface
{
    public function __construct(protected LocationRepository $locationRepository, protected RouteRepository $routeRepository)
    {
    }

    public function import(string $filePath): array
    {
        // Air-specific import logic goes here
        // Similar to WaterImportStrategy
    }
}

