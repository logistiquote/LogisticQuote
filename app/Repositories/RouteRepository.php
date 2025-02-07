<?php

namespace App\Repositories;

use App\Models\Route;

class RouteRepository
{
    public function getAll()
    {
        return Route::with(['origin', 'destination','containers'])->get();
    }

    public function create(array $data)
    {
        return Route::create($data);
    }


    // Must be remove when all route from different files will be the same
    public function updateViaCondition(array $data)
    {
        $route = Route::where([
            'origin_id' => $data['origin_id'],
            'destination_id' => $data['destination_id'],
            'type' => $data['type']
        ])->first();

        if ($route) {
            $route->update($data);
        }

        return $route;
    }

    public function createOrUpdate(array $data)
    {
        return Route::updateOrCreate(
            ['origin_id' => $data['origin_id'], 'destination_id' => $data['destination_id'], 'type' => $data['type']],
            $data
        );
    }
}


