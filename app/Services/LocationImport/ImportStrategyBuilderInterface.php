<?php

namespace App\Services\LocationImport;

interface ImportStrategyBuilderInterface
{
    public function build(string $type): ImportStrategyInterface;
}
