@extends('panels.layouts.master')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <div class="app-wrapper container mt-5">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Quotation Summary</h2>
                    <div class="mb-3">
                        <p><strong>Origin of shipment:</strong> <span class="text-muted">{{ $route->full_origin_location }}</span>
                        </p>
                        <p><strong>Destination of shipment:</strong> <span
                                class="text-muted">{{ $route->full_destination_location }}</span></p>
                        <p><strong>Ready to load:</strong> <span class="text-muted">{{ $ready_to_load_date }}</span></p>
                        <p><strong>Shipment type:</strong> <span class="text-muted">{{ strtoupper($type) }}</span></p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <p><strong>Incoterms:</strong> <span class="text-muted">{{ strtoupper($incoterms) }}</span></p>
                        <p><strong>Value of goods:</strong> <span
                                class="text-muted">${{ number_format($value_of_goods, 2) }}</span></p>
                    </div>
                    <hr>
                    <div>
                        <h2 class="mb-3">Containers Info</h2>
                        @foreach($current_containers as $container)
                            <p><strong>Container #{{ $loop->index + 1, $container['size'] }}:</strong>
                                <span class="text-muted">
                                    ${{$container['price'] != 0 ? number_format($container['price'], 2) : "Custom price. We'll contact you for more details" }}, weight - {{ $container['size'] }}</span>
                            </p>
                        @endforeach
                    </div>
                    <hr>
                    <div class="text-end">
                        <h2 class="fw-bold">Total, $:
                            {{ number_format(collect($current_containers)->sum('price'), 2) }}
                        </h2>
                    </div>
                    <form action="{{ route('quotation.index') }}" method="GET">
                        <button type="submit" class="btn btn-primary">
                            <span>Go to quotations</span>
                            <i class="fal fa-angle-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection
