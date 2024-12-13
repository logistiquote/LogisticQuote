<?php

namespace App\Http\Controllers;

use App\Enums\WaterContainerType;
use App\Http\Requests\RouteRequest;
use App\Models\Location;
use App\Models\Route;
use App\Services\RouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RouteController extends Controller
{
    public function __construct(protected RouteService $routeService)
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $routes = Route::with(['origin', 'destination'])->latest()->get();

        $data['routes'] = $routes->map(function ($route) {
            $origin = $route->origin;
            $destination = $route->destination;

            return [
                'id' => $route->id,
                'origin' => "$origin->country, $origin->name",
                'destination' => "$destination->country, $destination->name",
                'type' => ucfirst($route->type),
            ];
        });

        $data['page_name'] = 'routes';

        return view('panels.route.index', $data);
    }

    public function create()
    {
        $data['locations'] = Location::all();;
        $data['containerTypes'] = WaterContainerType::all();;
        $data['page_name'] = 'create_route';
        $data['page_title'] = 'Create Route | LogisticQuote';
        return view('panels.route.create', $data);
    }

    public function store(RouteRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $this->routeService->createRouteWithContainers($validatedData);

            return redirect()->route('route.index')->with('success', 'Route created successfully!');
        } catch (\Exception $e) {
            Log::error('RouteController(store). Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Failed to create the route. Please try again.');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $route = Route::with(['origin', 'destination', 'containers'])->findOrFail($id);

        $data['route'] = $route;
        $data['page_name'] = 'edit_route';
        $data['page_title'] = 'Edit Route | LogisticQuote';

        return view('panels.route.edit', $data);
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
