<?php

namespace App\Repositories;

use App\Models\Route;

class RouteRepository
{
    public function create(array $data)
    {
        return Route::create($data);
    }

    public function createOrUpdate(array $data)
    {
        return Route::updateOrCreate(
            ['origin_id' => $data['origin_id'], 'destination_id' => $data['destination_id'], 'type' => $data['type']],
            $data
        );
    }
}


