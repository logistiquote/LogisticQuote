<?php

namespace App\Services;

use App\Services\LocationImport\ImportStrategyBuilderInterface;
use App\Services\LocationImport\ImportStrategyInterface;
use Exception;

class LocationImportService
{
    protected $strategy;

    public function __construct(protected ImportStrategyBuilderInterface $strategyBuilder)
    {
    }

    public function setStrategy(string $type): void
    {
        $this->strategy = $this->strategyBuilder->build($type);
    }

    /**
     * @throws Exception
     */
    public function import(string $filePath): array
    {
        if (!$this->strategy) {
            throw new Exception('Import strategy is not set.');
        }

        return $this->strategy->import($filePath);
    }
}

