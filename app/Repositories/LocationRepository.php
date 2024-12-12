<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository
{
    public function createOrUpdate(array $data)
    {
        return Location::updateOrCreate(
            ['name' => $data['name'], 'type' => $data['type']],
            $data
        );
    }
}

