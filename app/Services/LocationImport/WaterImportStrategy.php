<?php

namespace App\Services\LocationImport;

use App\Enums\WaterContainerType;
use App\Repositories\LocationRepository;
use App\Repositories\RouteContainerRepository;
use App\Repositories\RouteRateRepository;
use App\Repositories\RouteRepository;

class WaterImportStrategy implements ImportStrategyInterface
{
    public function __construct(
        protected LocationRepository       $locationRepository,
        protected RouteRepository          $routeRepository,
        protected RouteContainerRepository $routeContainerRepository,
        protected RouteRateRepository      $routeRateRepository
    )
    {
    }

    public function import(string $filePath): array
    {
        $originalFileName = $this->getOriginalFileName($filePath);

        $type = $this->extractTypeFromFileName($originalFileName);

        $allowedTypes = ['fcl', 'lcl'];
        if (!in_array($type, $allowedTypes, true)) {
            throw new \InvalidArgumentException("Unsupported import type: {$type}. Allowed types are: " . implode(', ', $allowedTypes));
        }

        $data = array_map('str_getcsv', file($filePath));
        $header = array_map(fn($key) => strtolower(str_replace(' ', '_', $key)), array_shift($data));

        return $type === 'lcl' ? $this->importLCL($data, $header) : $this->importFCL($data, $header);
    }

    private function extractTypeFromFileName(string $fileName): string
    {
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);

        if (str_contains(strtolower($fileName), 'fcl')) {
            return 'fcl';
        } elseif (str_contains(strtolower($fileName), 'lcl')) {
            return 'lcl';
        }

        throw new \InvalidArgumentException("Could not determine type from file name: {$fileName}");
    }

    private function getOriginalFileName(string $filePath): string
    {
        foreach ($_FILES as $file) {
            if (isset($file['tmp_name']) && $file['tmp_name'] === $filePath) {
                return $file['name']; // Return the original file name
            }
        }

        throw new \RuntimeException("Original file name could not be determined for: {$filePath}");
    }


    private function importLCL(array $data, array $header): array
    {
        $results = [];

        foreach ($data as $row) {
            $record = array_combine($header, $row);

            $origin = $this->createLocation($record['country'], $record['country_code'], $record['pol']);
            $destination = $this->createLocation('Israel', 'IL', $record['pod']);

            $route = $this->createRoute(
                $origin->id,
                $destination->id,
                '',
                $record['transit_time'],
                '',
                'lcl',
            );

            if (empty($route)) {
                continue;
            }

            $this->routeRateRepository->createOrUpdate([
                'route_id' => $route->id,
                'ocean_freight' => $record['of'] ?? 0.00,
                'terminal_handling_charges' => $record['thc'] ?? 0.00,
                'total_price' => $record['total'] ?? 0.00,
                'min_ocean_freight' => $record['min_of'] ?? 0.00,
                'destination_charges' => $record['destination_charges'] ?? 0.00,
            ]);

            $results[] = $route;
        }

        return $results;
    }

    private function importFCL(array $data, array $header): array
    {
        $results = [];

        foreach ($data as $row) {
            $record = array_combine($header, $row);
            $origin = $this->createLocation($record['country'], $record['country_code'], $record['pol']);
            $destination = $this->createLocation('Israel', 'IL', $record['pod']);

            $route = $this->createRoute(
                $origin->id,
                $destination->id,
                $record['shipping_line'],
                $record['transit_time'],
                $record['validity'] ?? '',
            );

            foreach (WaterContainerType::all() as $containerType) {
                $priceField = strtolower($containerType);
                $this->routeContainerRepository->createOrUpdate([
                    'route_id' => $route->id,
                    'container_type' => $containerType,
                    'price' => $record[$priceField] ?? 0.00,
                ]);
            }

            $results[] = $route;
        }

        return $results;
    }

    private function createLocation(string $country, string $code, string $name)
    {
        return $this->locationRepository->createOrUpdate([
            'country' => $country,
            'country_code' => $code,
            'name' => $name,
            'type' => 'water',
        ]);
    }

    private function createRoute(int $originId, int $destinationId, string $shippingLine, string $transitTime, string $priceValidUntil = '', string $fileType = '')
    {
        $data = [
            'origin_id' => $originId,
            'destination_id' => $destinationId,
            'type' => 'water',
        ];

        if ($fileType === 'lcl') {
            $data['lcl_delivery_time'] = $transitTime;
        } else {
            $data['fcl_delivery_time'] = $transitTime;
        }

        if (!empty($shippingLine)) {
            $data['delivery_line'] = $shippingLine;
        }

        if (!empty($priceValidUntil)) {
            $data['price_valid_until'] = $priceValidUntil;
        }

        if ($fileType) {
            return $this->routeRepository->updateViaCondition($data);
        } else {
            return $this->routeRepository->createOrUpdate($data);
        }
    }
}
