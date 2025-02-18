<div class="app-wrapper container mt-5">
    <div class="card shadow">
        <div class="card-body">
            @php
                $path = public_path('frontend/images/site/logo.png');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            @endphp
            <img src="{{ $base64 }}" alt="Company Logo" style="width: 120px; height: auto;">

            <h2 class="card-title mb-4 mt-4">Quotation Summary</h2>
            <div>
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
                <p>
                    <strong>Destination of shipment:</strong>
                    <span class="text-muted">
                        {{ $quotation->route->full_destination_location }}
                    </span>
                </p>
                <p>
                    <strong>Ready to load:</strong>
                    <span class="text-muted">
                        {{ $quotation->ready_to_load_date }}
                    </span>
                </p>
                <p>
                    <strong>Shipment type:</strong>
                    <span class="text-muted">
                        {{ strtoupper($quotation->type) }}
                    </span>
                </p>
                <p>
                    <strong>Incoterms:</strong>
                    <span class="text-muted">
                        {{ strtoupper($quotation->incoterms) }}
                    </span>
                </p>
                <p>
                    <strong>Value of goods:</strong>
                    <span class="text-muted">
                        ${{ number_format($quotation->value_of_goods, 2) }}
                    </span>
                </p>
                @if($quotation->type === 'lcl')
                    <p>
                        <strong>Destination charges:</strong>
                        <span class="text-muted">
                        ${{ number_format($quotation->route->rate->destination_charges, 2) }}
                    </span>
                    </p>
                    <p>
                        <strong>Estimated transit time:</strong>
                        <span class="text-muted">
                        {{ $quotation->route->lcl_delivery_time}} days
                    </span>
                    </p>
                    <p>
                        <strong>Price valid until:</strong>
                        <span class="text-muted">
                        {{ $quotation->route->price_valid_until}}
                    </span>
                    </p>
                @endif
            </div>
            @if($quotation->type === 'fcl')
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
            @elseif($quotation->type === 'lcl')
                <div>
                    <h2 class="mb-3">Price Breakdown</h2>
                    @if($quotation->pallets->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Pallet #</th>
                                <th>Length (cm)</th>
                                <th>Width (cm)</th>
                                <th>Height (cm)</th>
                                <th>Volume (cbm)</th>
                                <th>Gross Weight (kg)</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quotation->pallets as $index => $pallet)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>{{ $pallet->length ?? 'N/A' }}</td>
                                    <td>{{ $pallet->width ?? 'N/A' }}</td>
                                    <td>{{ $pallet->height ?? 'N/A' }}</td>
                                    <td>{{ $pallet->volumetric_weight ?? 'N/A' }}</td>
                                    <td>{{ $pallet->gross_weight ?? 'N/A' }}</td>
                                    <td>{{ $pallet->quantity ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No pallet information available.</p>
                    @endif
                </div>
            @endif

            <div class="text-end">
                <h2 class="fw-bold">Insurance price, $:
                    {{ number_format($quotation->insurance_price, 2) }}
                </h2>
            </div>
            <hr>
            <div class="text-end">
                <h2 class="fw-bold">Total price, $:
                    {{ number_format($quotation->total_price, 2) }}
                </h2>
            </div>
            <div class="info-block">
                <h3>INCLUSIONS/EXCLUSIONS</h3>
                <ul>
                    <li>The quote is valid from its issue date and for a maximum period of 30 minutes from the time of its issuance.</li>
                    <li>The quote is based on standard live load/unload (2 hours free for loading/unloading container).</li>
                    <li>Transit times are estimated by the carriers, and may vary depending on sailing dates of the specific capacity, port/CFS congestion delay, carrier rolling, vessel change, chassis shortage or customs delays etc. Some areas in China are considered remote pickup addresses and may take an additional 2-3 days.</li>
                    <li>85 USD Export License fee will be applied if applicable. (only for export)</li>
                    <li>Sensitive and DG goods surcharge will be applied if applicable.</li>
                    <li>The quote does not include: detention, per diem, demurrage, storage, port congestion fee or any requested additional services.</li>
                    <li>This quotation is provided by the Company as an estimate, dependent on information provided by the Customer.</li>
                    <li>Cargo requiring special handling such as hazardous goods, perishable cargo, oversized cargo, overweight containers, and non-stackable cargo may be subject to additional charges.</li>
                    <li>Cargo pickup and/or delivery which requires after-hours delivery, tailgate delivery, appointment delivery, hand load/unload, inside delivery, residential delivery, rush delivery, multiple stops, diversion miles, and deliveries requiring special equipment may be subject to additional charges.</li>
                    <li>Any taxes, including export and import customs duties, excise taxes, VAT, and other fees levied on the cargo being exported/imported; fees for the processing of letters of credit; and fees in connection with any legalization, notarization, or other certified attestation required, are all excluded from the quotation.</li>
                    <li>There can be changes in cost due to empty equipment availability, space availability, cargo acceptance, and confirmation at the time of booking may affect the final shipment price.</li>
                    <li>At the Company’s discretion, this quotation will become void due to cargo that is mis-declared.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .info-block {
        background-color: #f3f4f6;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        page-break-before: always;
    }
    .info-block h3 {
        color: gray;
        font-size: 18px;
        margin-bottom: 12px;
    }
    .info-block ul {
        color: gray;
        list-style-type: disc;
        padding-left: 20px;
    }
    .info-block ul li {
        margin-bottom: 4px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th {
        background-color: #f8f9fa;
        text-align: left;
    }
    .table td, .table th {
        padding: 8px;
        border: 1px solid #dee2e6;
    }
</style>
