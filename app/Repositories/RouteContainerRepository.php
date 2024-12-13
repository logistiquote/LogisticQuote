<?php

namespace App\Repositories;

use App\Models\RouteContainer;

class RouteContainerRepository
{
    public function create(array $data)
    {
        return RouteContainer::create($data);
    }

    public function createOrUpdate(array $data)
    {
        return RouteContainer::updateOrCreate(
            ['route_id' => $data['route_id'], 'container_type' => $data['container_type']],
            $data
        );
    }
}


