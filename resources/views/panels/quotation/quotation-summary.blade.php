<div class="app-wrapper container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">Quotation Summary</h2>
            <div class="mb-3">
                <p>
                    <strong>
                        Quotation Number: {{ $quotation->quote_number }}
                    </strong>
                </p>
                <p>
                    <strong>
                        Origin of shipment:
                    </strong>
                    <span class="text-muted">
                        {{ $quotation->route->full_origin_location }}
                    </span>
                </p>
                <p><strong>Destination of shipment:</strong> <span
                        class="text-muted">{{ $quotation->route->full_destination_location }}</span></p>
                <p><strong>Ready to load:</strong> <span class="text-muted">{{ $quotation->ready_to_load_date }}</span>
                </p>
                <p><strong>Shipment type:</strong> <span class="text-muted">{{ strtoupper($quotation->type) }}</span>
                </p>
            </div>
            <hr>
            <div class="mb-3">
                <p><strong>Incoterms:</strong> <span class="text-muted">{{ strtoupper($quotation->incoterms) }}</span>
                </p>
                <p><strong>Value of goods:</strong> <span
                        class="text-muted">${{ number_format($quotation->value_of_goods, 2) }}</span></p>
            </div>
            <hr>
            <div>
                <h2 class="mb-3">Containers Info</h2>
                @foreach($quotation->containers as $container)
                    <p>
                        <strong>
                            Container #{{ $loop->index + 1 }} {{$container->routeContainer->container_type}}:
                        </strong>
                        <span class="text-muted">
                            {{
                                $container->price_per_container != 0
                                ? "$" . number_format($container->price_per_container, 2) . " weight - $container->weight"
                                : "We'll contact you for payment and delivery information about your quotation"
                            }}
                        </span>
                    </p>
                @endforeach
            </div>
            <hr>
            <div class="text-end">
                <h2 class="fw-bold">Insurance price, $:
                    {{ number_format($quotation->insurance_price, 2) }}
                </h2>
            </div>
            <hr>
            <div class="text-end">
                <h2 class="fw-bold">Total, $:
                    {{ number_format($quotation->total_price, 2) }}
                </h2>
            </div>
        </div>
    </div>
</div>
