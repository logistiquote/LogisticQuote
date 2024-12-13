<?php

namespace App\Services;

use App\Repositories\RouteContainerRepository;
use App\Repositories\RouteRepository;
use Exception;
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
}
