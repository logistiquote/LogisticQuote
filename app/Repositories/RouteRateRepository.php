<?php

namespace App\Repositories;

use App\Models\RouteRate;

class RouteRateRepository
{
    public function createOrUpdate(array $data): RouteRate
    {
        return RouteRate::updateOrCreate(
            ['route_id' => $data['route_id']],
            $data
        );
    }
}
