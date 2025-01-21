@extends('frontend.layouts.app')
@section('content')

<div class="app-wrapper container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">Quotation Summary</h2>
            <div class="mb-3">
                <p><strong>Origin of shipment:</strong> <span class="text-muted">{{ $pickup_address }}</span></p>
                <p><strong>Destination of shipment:</strong> <span class="text-muted">{{ $final_destination_address }}</span></p>
                <p><strong>Ready to load:</strong> <span class="text-muted">{{ $ready_to_load_date }}</span></p>
                <p><strong>Shipment type:</strong> <span class="text-muted">{{ strtoupper($type) }}</span></p>
            </div>
            <hr>
            <div class="mb-3">
                <p><strong>Incoterms:</strong> <span class="text-muted">{{ strtoupper($incoterms) }}</span></p>
                <p><strong>Value of goods:</strong> <span class="text-muted">${{ number_format($value_of_goods, 2) }}</span></p>
            </div>
            <hr>
            <div>
                <h2 class="mb-3">Containers Info</h2>
                @foreach($current_containers as $container)
                    <p><strong>Container #{{ $loop->index + 1, $container['size'] }}:</strong>
                        <span class="text-muted">${{ number_format($container['price'], 2) }}, weight - {{ $container['size'] }}</span>
                    </p>
                @endforeach
            </div>
            <hr>
            <div class="text-end">
                <h2 class="fw-bold">Total, $:
                    {{ number_format(collect($current_containers)->sum('price'), 2) }}
                </h2>
            </div>
            <form action="{{ route('frontend.quote_final_step') }}" method="POST">
                @csrf
                <h4>You must to be logged in to finish your quotation</h4>
                <button type="submit" class="request-btn next " style="background: rgb(243, 156, 1);">
                    <span>Login to payment</span>
                    <i class="fal fa-angle-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
