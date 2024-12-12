<?php

namespace App\Services\LocationImport;

interface ImportStrategyInterface
{
    public function import(string $filePath): array;
}
