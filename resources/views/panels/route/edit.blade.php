@extends('panels.layouts.master')
@section('content')

    <div class="row">
        <div class="col-xl-10 col-md-12 mb-4 offset-md-1">
            <div class="card shadow">
                <h5 class="card-header">
                    Edit Route
                    <span class="badge badge-info">{{ ucfirst($route->type) }}</span>
                </h5>
                <div class="card-body">
                    <form>
                        <!-- Route Details -->
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <h5><b>Origin</b></h5>
                                <input type="text" class="form-control" value="{{ $route->full_origin_location }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5><b>Destination</b></h5>
                                <input type="text" class="form-control" value="{{ $route->full_destination_location }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <h5><b>Route Type</b></h5>
                                <input type="text" class="form-control" value="{{ ucfirst($route->type) }}" readonly>
                            </div>
                        </div>

                        <!-- Containers -->
                        <h5 class="mt-4"><b>Containers</b></h5>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($route->containers as $container)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" value="{{ $container->container_type }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="{{ number_format($container->price, 2) }}" readonly>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('route.index') }}" class="btn btn-secondary mt-3">Back to Routes</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
