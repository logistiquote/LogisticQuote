<?php

namespace App\Services;

use App\Repositories\RouteContainerRepository;
use App\Repositories\RouteRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RouteService
{
    public function __construct(
        protected RouteRepository          $routeRepository,
        protected RouteContainerRepository $routeContainerRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function createRouteWithContainers(array $data)
    {
        DB::beginTransaction();

        try {
            $route = $this->routeRepository->create([
                'origin_id' => $data['origin_id'],
                'destination_id' => $data['destination_id'],
                'type' => $data['type'],
            ]);

            foreach ($data['containers'] as $container) {
                $this->routeContainerRepository->create([
                    'route_id' => $route->id,
                    'container_type' => $container['type'],
                    'price' => $container['price'],
                ]);
            }

            DB::commit();

            return $route;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getAllRoutes()
    {
        return $this->routeRepository->getAll();
    }

    /**
     * Get unique origins from routes.
     *
     * @param Collection $allRoutes
     * @return Collection
     */
    public function getUniqueOrigins($allRoutes): Collection
    {
        return $allRoutes->map(function ($route) {
            return [
                'id' => $route->origin_id,
                'route_id' => $route->id,
                'containers' => $route->containers,
                'destination_id' => $route->destination_id,
                'full_location' => $route->origin->full_location,
            ];
        });
    }

    /**
     * Get unique destinations from routes.
     *
     * @param Collection $allRoutes
     * @return Collection
     */
    public function getUniqueDestinations($allRoutes)
    {
        return $allRoutes->map(function ($route) {
            return [
                'id' => $route->destination_id,
                'route_id' => $route->id,
                'containers' => $route->containers,
                'origin_id' => $route->origin_id,
                'full_location' => $route->destination->full_location,
            ];
        });
    }
}
