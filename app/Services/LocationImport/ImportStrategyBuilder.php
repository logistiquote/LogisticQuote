<?php

namespace App\Services\LocationImport;

class ImportStrategyBuilder implements ImportStrategyBuilderInterface
{
    public function build(string $type): ImportStrategyInterface
    {
        $strategies = [
            'water' => WaterImportStrategy::class,
            'air' => AirImportStrategy::class,
        ];

        if (!array_key_exists($type, $strategies)) {
            throw new \InvalidArgumentException("Invalid type: {$type}");
        }

        return app($strategies[$type]);
    }
}

