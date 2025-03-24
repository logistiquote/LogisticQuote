@extends('frontend.layouts.app')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #333;
            color: #fff;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            font-size: 14px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: #0056b3;
        }

    </style>
    <div class="container">
        <h2>DHL Shipping Quote</h2>

        @include('panels.includes.errors')

        @if(isset($quote['products']) && count($quote['products']) > 0)
            <table>
                <thead>
                <tr>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Delivery Time</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($quote['products'] as $service)
                    @php
                        $firstPrice = $service['totalPrice'][count($service['totalPrice']) - 1]['price'] ?? 0;
                        $currency = $service['totalPrice'][count($service['totalPrice']) - 1]['priceCurrency'] ?? 'N/A';
                        $deliveryTime = $service['deliveryCapabilities']['estimatedDeliveryDateTime'] ?? 'N/A';
                    @endphp

                    <tr>
                        <td><strong>{{ $service['productName'] }}</strong></td>
                        <td style="color: green;">${{ number_format($firstPrice, 2) }} {{ $currency }}</td>
                        <td>{{ $deliveryTime }}</td>
                        <td>
                            <button type="button" class="btn select-service" data-service="{{ $service['productCode'] }}">
                                Select
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Form moved outside the table -->
            <form id="shipment-form" action="{{ route('dhl.shipment') }}" method="POST" class="mt-5 form active" enctype="multipart/form-data">
                @csrf

                <h3>Shipper Details</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label class="quotation-label" for="origin_full_name">Full Name *</label>
                        <input type="text" id="origin_full_name" name="origin_full_name" required maxlength="100" value="{{ old('origin_full_name') }}">
                    </div>

                    <div class="input-group">
                        <label for="origin_company_name">Company Name *</label>
                        <input type="text" id="origin_company_name" name="origin_company_name" required maxlength="100" value="{{ old('origin_company_name') }}">
                    </div>

                    <div class="input-group">
                        <label for="origin_postal_code">Postal Code *</label>
                        <input type="text" id="origin_postal_code" name="origin_postal_code" required maxlength="12" value="{{ old('origin_postal_code') }}">
                    </div>

                    <div class="input-group">
                        <label for="origin_address_line1">Address Line 1 *</label>
                        <input type="text" id="origin_address_line1" name="origin_address_line1" required maxlength="255" value="{{ old('origin_address_line1') }}">
                    </div>

                    <div class="input-group">
                        <label for="origin_contact_email">Email *</label>
                        <input type="email" id="origin_contact_email" name="origin_contact_email" required maxlength="255" value="{{ old('origin_contact_email') }}">
                    </div>

                    <div class="input-group">
                        <label for="origin_contact_phone">Phone *</label>
                        <input type="text" id="origin_contact_phone" name="origin_contact_phone" required maxlength="20" value="{{ old('origin_contact_phone') }}">
                    </div>
                </div>

                <h3 class="mt-3">Receiver Details</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="destination_full_name">Full Name *</label>
                        <input type="text" id="destination_full_name" name="destination_full_name" required maxlength="100" value="{{ old('destination_full_name') }}">
                    </div>

                    <div class="input-group">
                        <label for="destination_company_name">Company Name *</label>
                        <input type="text" id="destination_company_name" name="destination_company_name" required maxlength="100" value="{{ old('destination_company_name') }}">
                    </div>

                    <div class="input-group">
                        <label for="destination_postal_code">Postal Code *</label>
                        <input type="text" id="destination_postal_code" name="destination_postal_code" required maxlength="12" value="{{ old('destination_postal_code') }}">
                    </div>

                    <div class="input-group">
                        <label for="destination_address_line1">Address Line 1 *</label>
                        <input type="text" id="destination_address_line1" name="destination_address_line1" required maxlength="255" value="{{ old('destination_address_line1') }}">
                    </div>

                    <div class="input-group">
                        <label for="destination_contact_email">Email *</label>
                        <input type="email" id="destination_contact_email" name="destination_contact_email" required maxlength="255" value="{{ old('destination_contact_email') }}">
                    </div>

                    <div class="input-group">
                        <label for="destination_contact_phone">Phone *</label>
                        <input type="text" id="destination_contact_phone" name="destination_contact_phone" required maxlength="20" value="{{ old('destination_contact_phone') }}">
                    </div>
                </div>

                <h3 class="mt-3">Package Details</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="weight">Weight (kg) *</label>
                        <input type="number" id="weight" name="weight" disabled required min="0.1" max="1000" value="{{ $dimension['weight'] }}">
                    </div>

                    <div class="input-group">
                        <label for="length">Length (cm) *</label>
                        <input type="number" id="length" name="length" disabled required min="1" max="300" value="{{ $dimension['length'] }}">
                    </div>

                    <div class="input-group">
                        <label for="width">Width (cm) *</label>
                        <input type="number" id="width" name="width" disabled required min="1" max="120" value="{{ $dimension['width'] }}">
                    </div>

                    <div class="input-group">
                        <label for="height">Height (cm) *</label>
                        <input type="number" id="height" name="height" disabled required min="1" max="160" value="{{ $dimension['height'] }}">
                    </div>
                </div>

                <h3 class="mt-3">Additional Information</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="description">Description *</label>
                        <input type="text" id="description" name="description" required maxlength="255" value="{{ old('description') }}">
                    </div>

                    <div class="input-group">
                        <label for="declared_value">Declared Value *</label>
                        <input type="number" id="declared_value" name="declared_value" required min="0" value="{{ old('declared_value') }}">
                    </div>

                    <div class="input-group">
                        <label for="declared_value_currency">Currency *</label>
                        <select id="declared_value_currency" name="declared_value_currency" required>
                            <option value="USD" {{ old('declared_value_currency') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                            <option value="EUR" {{ old('declared_value_currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            <option value="ILS" {{ old('declared_value_currency') == 'ILS' ? 'selected' : '' }}>ILS - Israeli Shekel</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="invoice_pdf">Upload Invoice (PDF) *</label>
                        <input type="file" id="invoice_pdf" name="invoice_pdf" accept="application/pdf">
                    </div>
                </div>

                <h3>Invoice Details</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="invoice_number">Invoice Number *</label>
                        <input type="text" id="invoice_number" name="invoice[number]" required maxlength="100" value="{{ old('invoice.number', '') }}">
                    </div>

                    <div class="input-group">
                        <label for="invoice_date">Invoice Date *</label>
                        <input type="date" id="invoice_date" name="invoice[date]" required value="{{ old('invoice.date', '') }}">
                    </div>
                </div>

                <h3 class="mt-3">Line Items</h3>
                <div id="lineItemsContainer">
                    @php $lineItems = old('lineItems', [['description' => '', 'price' => '', 'quantity' => ['value' => '', 'unitOfMeasurement' => 'PCS'], 'manufacturerCountry' => '', 'weight' => ['netValue' => '', 'grossValue' => '']]]); @endphp

                    @foreach ($lineItems as $index => $item)
                        <div class="line-item" data-index="{{ $index }}">
                            <h4>Item #<span class="item-number">{{ $index + 1 }}</span></h4>

                            <div class="form-grid">
                                <div class="input-group">
                                    <label for="lineItems_{{ $index }}_description">Description *</label>
                                    <input type="text" id="lineItems_{{ $index }}_description" name="lineItems[{{ $index }}][description]" required value="{{ $item['description'] }}">
                                </div>

                                <div class="input-group">
                                    <label for="lineItems_{{ $index }}_price">Price *</label>
                                    <input type="number" id="lineItems_{{ $index }}_price" name="lineItems[{{ $index }}][price]" required min="0" step="0.01" value="{{ $item['price'] }}">
                                </div>

                                <div class="input-group">
                                    <label for="lineItems_{{ $index }}_quantity_value">Quantity *</label>
                                    <input type="number" id="lineItems_{{ $index }}_quantity_value" name="lineItems[{{ $index }}][quantity][value]" required min="1" value="{{ $item['quantity']['value'] }}">
                                </div>

                                <div class="input-group">
                                    <label for="lineItems_{{ $index }}_unitOfMeasurement">Unit of Measurement *</label>
                                    <select id="lineItems_{{ $index }}_unitOfMeasurement" name="lineItems[{{ $index }}][quantity][unitOfMeasurement]" required>
                                        <option value="PCS" {{ $item['quantity']['unitOfMeasurement'] == 'PCS' ? 'selected' : '' }}>PCS</option>
                                        <option value="KG" {{ $item['quantity']['unitOfMeasurement'] == 'KG' ? 'selected' : '' }}>KG</option>
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="lineItems_{{ $index }}_manufacturerCountry">Manufacturer Country *</label>
                                    <input type="text" id="lineItems_{{ $index }}_manufacturerCountry" name="lineItems[{{ $index }}][manufacturerCountry]" maxlength="2" required value="{{ $item['manufacturerCountry'] }}">
                                </div>

                                <div class="input-group">
                                    <label for="lineItems_{{ $index }}_netWeight">Net Weight *</label>
                                    <input type="number" id="lineItems_{{ $index }}_netWeight" name="lineItems[{{ $index }}][weight][netValue]" required min="0" value="{{ $item['weight']['netValue'] }}">
                                </div>

                                <div class="input-group">
                                    <label for="lineItems_{{ $index }}_grossWeight">Gross Weight *</label>
                                    <input type="number" id="lineItems_{{ $index }}_grossWeight" name="lineItems[{{ $index }}][weight][grossValue]" required min="0" value="{{ $item['weight']['grossValue'] }}">
                                </div>
                            </div>
                            <button type="button" class="remove-item btn btn-danger mt-2" style="{{ $index == 0 ? 'display: none' : 'display: block' }}">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="addItem" class="btn btn-secondary mt-3">Add Item</button>

                <input type="hidden" id="selected_service" name="service" value="{{ old('service') }}">
                <button type="submit" class="btn mt-3">Submit</button>
            </form>

        @else
            <div class="alert alert-warning">
                <strong>No shipping options available.</strong> Please try again.
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lineItemsContainer = document.getElementById("lineItemsContainer");
            const addItemButton = document.getElementById("addItem");

            let lineItemIndex = document.querySelectorAll(".line-item").length;

            // Function to add a new line item
            function addLineItem() {
                const newItem = document.createElement("div");
                newItem.classList.add("line-item");
                newItem.setAttribute("data-index", lineItemIndex);
                newItem.innerHTML = `
            <h4>Item #<span class="item-number">${lineItemIndex + 1}</span></h4>
            <div class="form-grid">
                <div class="input-group">
                    <label>Description *</label>
                    <input type="text" name="lineItems[${lineItemIndex}][description]" required>
                </div>
                <div class="input-group">
                    <label>Price *</label>
                    <input type="number" name="lineItems[${lineItemIndex}][price]" required min="0" step="0.01">
                </div>
                <div class="input-group">
                    <label>Quantity *</label>
                    <input type="number" name="lineItems[${lineItemIndex}][quantity][value]" required min="1">
                </div>
                <div class="input-group">
                    <label>Unit of Measurement *</label>
                    <select name="lineItems[${lineItemIndex}][quantity][unitOfMeasurement]" required>
                        <option value="PCS">PCS</option>
                        <option value="KG">KG</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Manufacturer Country *</label>
                    <input type="text" name="lineItems[${lineItemIndex}][manufacturerCountry]" maxlength="2" required>
                </div>
                <div class="input-group">
                    <label>Net Weight *</label>
                    <input type="number" name="lineItems[${lineItemIndex}][weight][netValue]" required min="0">
                </div>
                <div class="input-group">
                    <label>Gross Weight *</label>
                    <input type="number" name="lineItems[${lineItemIndex}][weight][grossValue]" required min="0">
                </div>
            </div>
            <button type="button" class="remove-item btn btn-danger mt-2">Remove</button>
        `;

                lineItemsContainer.appendChild(newItem);
                lineItemIndex++;

                updateRemoveButtons();
            }

            // Function to update remove button visibility
            function updateRemoveButtons() {
                const removeButtons = document.querySelectorAll(".remove-item");
                removeButtons.forEach((button, index) => {
                    button.style.display = index === 0 ? "none" : "block"; // Hide remove button for first item
                });
            }

            // Add new line item
            addItemButton.addEventListener("click", addLineItem);

            // Remove line item
            lineItemsContainer.addEventListener("click", function(event) {
                if (event.target.classList.contains("remove-item")) {
                    event.target.parentElement.remove();
                    updateItemNumbers();
                    updateRemoveButtons();
                }
            });

            // Update item numbers after removal
            function updateItemNumbers() {
                document.querySelectorAll(".line-item").forEach((item, index) => {
                    item.querySelector(".item-number").textContent = index + 1;
                    item.setAttribute("data-index", index);
                });
                lineItemIndex = document.querySelectorAll(".line-item").length;
            }

            // Initial check to hide the remove button for the first item
            updateRemoveButtons();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll(".select-service");
            const hiddenInput = document.getElementById("selected_service");
            const submitButton = document.querySelector("#shipment-form button[type='submit']");

            buttons.forEach(button => {
                button.addEventListener("click", function () {
                    hiddenInput.value = this.getAttribute("data-service");
                    submitButton.disabled = false;
                    submitButton.style.display = "block";
                });
            });
        });
    </script>
@endsection
