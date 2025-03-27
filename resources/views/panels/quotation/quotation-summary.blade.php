<div class="invoice-container">
    <div class="header">
        @php
            $path = public_path('frontend/images/site/logo.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        @endphp
        <img src="{{ $base64 }}" alt="Company Logo">
    </div>

    <h2 class="invoice-title">Quotation Summary</h2>

    <table class="details-table">
        <tr>
            <td><strong>Quotation Number:</strong> {{ $quotation->quote_number }}</td>
            <td><strong>Date:</strong> {{ $quotation->created_at->format('d F Y') }}</td>
            <td><strong>Ready to Load:</strong> {{ $quotation->ready_to_load_date }}</td>
        </tr>
        <tr>
            @if($quotation->type === 'DHL')
                @php
                $shipment = $quotation->shipment->shipment_data;
                    @endphp
                <td style="width: 50%; vertical-align: top;">
                    <h3>Origin</h3>
                    <p><strong>Name:</strong> {{ $shipment['origin_full_name'] }}</p>
                    <p><strong>Company:</strong> {{ $shipment['origin_company_name'] }}</p>
                    <p><strong>Address:</strong> {{ $shipment['origin_address_line1'] }}</p>
                    <p><strong>City:</strong> {{ $shipment['origin_city'] }}</p>
                    <p><strong>Postal Code:</strong> {{ $shipment['origin_postal_code'] }}</p>
                    <p><strong>Country:</strong> {{ $shipment['origin_country'] }}</p>
                    <p><strong>Email:</strong> {{ $shipment['origin_contact_email'] }}</p>
                    <p><strong>Phone:</strong> {{ $shipment['origin_contact_phone'] }}</p>
                </td>

                <td style="width: 50%; vertical-align: top;">
                    <h3>Destination</h3>
                    <p><strong>Name:</strong> {{ $shipment['destination_full_name'] }}</p>
                    <p><strong>Company:</strong> {{ $shipment['destination_company_name'] }}</p>
                    <p><strong>Address:</strong> {{ $shipment['destination_address_line1'] }}</p>
                    <p><strong>City:</strong> {{ $shipment['destination_city'] }}</p>
                    <p><strong>Postal Code:</strong> {{ $shipment['destination_postal_code'] }}</p>
                    <p><strong>Country:</strong> {{ $shipment['destination_country'] }}</p>
                    <p><strong>Email:</strong> {{ $shipment['destination_contact_email'] }}</p>
                    <p><strong>Phone:</strong> {{ $shipment['destination_contact_phone'] }}</p>
                </td>
                <td></td>
            @else
                <td><strong>Origin of Shipment:</strong> {{ $quotation->route->full_origin_location }}</td>
                <td><strong>Destination:</strong> {{ $quotation->route->full_destination_location }}</td>
                <td><strong>Due Date:</strong>
                    {{
                        \Carbon\Carbon::parse($quotation->ready_to_load_date)
                            ->addDays($quotation->type === 'fcl'
                                ? $quotation->route->fcl_delivery_time
                                : $quotation->route->lcl_delivery_time
                            )
                            ->format('d F Y')
                    }}
                </td>
            @endif
        </tr>
    </table>

    <div class="client-info">
        <h3>Client Information</h3>
        <p><strong>Shipment Type:</strong> {{ strtoupper($quotation->type) }}</p>
        @if($quotation->type === 'DHL')
        <p><strong>Incoterms:</strong> {{ strtoupper($quotation->incoterms) }}</p>
        @endif
        <p><strong>Value of Goods:</strong> ${{ number_format($quotation->value_of_goods, 2) }}</p>
    </div>

    <h3 class="mt-4">Price Breakdown</h3>
    <table class="items">
        <thead>
        <tr>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price per Unit</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @if($quotation->type === 'fcl')
            @foreach($quotation->containers as $container)
                <tr class="{{ $loop->even ? 'gray-row' : '' }}">
                    <td>Container #{{ $loop->index + 1 }} ({{ $container->routeContainer->container_type }})</td>
                    <td>1</td>
                    <td>${{ number_format($container->price_per_container, 2) }}</td>
                    <td>${{ number_format($container->price_per_container, 2) }}</td>
                </tr>
            @endforeach
        @elseif($quotation->type === 'lcl' && $quotation->pallets->count() > 0)
            @foreach($quotation->pallets as $index => $pallet)
                <tr class="{{ $loop->even ? 'gray-row' : '' }}">
                    <td>Pallet #{{ $index + 1 }}</td>
                    <td>{{ $pallet->quantity }}</td>
                    <td>${{ number_format($quotation->route->rate->destination_charges, 2) }}</td>
                    <td>${{ number_format($pallet->quantity * $quotation->route->rate->destination_charges, 2) }}</td>
                </tr>
            @endforeach
        @elseif($quotation->type === 'DHL')
        @endif
        </tbody>
    </table>


    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: left;">
                <h3>Payment Information</h3>
                <p><strong>Bank Transfer</strong></p>
                <p>Account Number: 123-456-7890</p>
                <p>Account Name: Your Company Name</p>
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <table style="width: 100%; border-collapse: collapse; border: 1px solid gray; margin-top: 16px">
                    <tr>
                        <td style="font-weight: bold; padding: 10px;">INSURANCE PRICE</td>
                        <td style="background: #000; color: #fff; padding: 10px; text-align: center; font-size: 24px; font-weight: 700">
                            ${{ number_format($quotation->insurance_price, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 10px;">TOTAL</td>
                        <td style="background: #000; color: #fff; padding: 10px; text-align: center; font-size: 24px; font-weight: 700">
                            ${{ number_format($quotation->total_price, 2) }}
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>


    <div class="info-block">
        <h3>Inclusions & Exclusions</h3>
        <ul>
            <li>The quote is valid from its issue date and for a maximum period of 30 minutes from the time of its
                issuance.
            </li>
            <li>The quote is based on standard live load/unload (2 hours free for loading/unloading container).</li>
            <li>Transit times are estimated by the carriers, and may vary depending on sailing dates of the specific
                capacity, port/CFS congestion delay, carrier rolling, vessel change, chassis shortage or customs delays
                etc. Some areas in China are considered remote pickup addresses and may take an additional 2-3 days.
            </li>
            <li>85 USD Export License fee will be applied if applicable. (only for export)</li>
            <li>Sensitive and DG goods surcharge will be applied if applicable.</li>
            <li>The quote does not include: detention, per diem, demurrage, storage, port congestion fee or any
                requested additional services.
            </li>
            <li>This quotation is provided by the Company as an estimate, dependent on information provided by the
                Customer.
            </li>
            <li>Cargo requiring special handling such as hazardous goods, perishable cargo, oversized cargo, overweight
                containers, and non-stackable cargo may be subject to additional charges.
            </li>
            <li>Cargo pickup and/or delivery which requires after-hours delivery, tailgate delivery, appointment
                delivery, hand load/unload, inside delivery, residential delivery, rush delivery, multiple stops,
                diversion miles, and deliveries requiring special equipment may be subject to additional charges.
            </li>
            <li>Any taxes, including export and import customs duties, excise taxes, VAT, and other fees levied on the
                cargo being exported/imported; fees for the processing of letters of credit; and fees in connection with
                any legalization, notarization, or other certified attestation required, are all excluded from the
                quotation.
            </li>
            <li>There can be changes in cost due to empty equipment availability, space availability, cargo acceptance,
                and confirmation at the time of booking may affect the final shipment price.
            </li>
            <li>At the Company’s discretion, this quotation will become void due to cargo that is mis-declared.</li>
        </ul>
    </div>

    <div class="footer">

    </div>
</div>

<style>
    .invoice-container {
        max-width: 900px;
        margin: auto;
        background: #fff;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        text-align: left;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
    }

    .header img {
        width: 120px;
        height: auto;
    }

    .invoice-title {
        font-size: 24px;
        margin: 20px 0;
        text-align: center;
    }

    .client-info {
        margin-top: 20px;
    }

    .details-table, .items {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .details-table td {
        border: 1px solid #000;
    }

    .details-table td, .items th, .items td {
        padding: 8px;
        text-align: left;
    }

    .items th {
        background: #000;
        color: #fff;
    }

    .gray-row {
        background-color: #f2f2f2;
    }

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

    .footer {
        text-align: center;
        margin-top: 30px;
        font-weight: bold;
    }
</style>
