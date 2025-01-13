@extends('frontend.layouts.app')
@section('content')
    <div class="main-content">
        <div class="wrapper-home-pages">
            <section class="wrapper-header-block">
                @php
                    $uniqueOrigins = collect($origins)->unique('full_location');
                    $uniqueDestinations = collect($destinations)->unique('full_location');
                @endphp
                <div class="container body">
                    <div class="left-column">
                        <div class="delivery-illustrations">
                        </div>
                        <div class="text-block">
                            <p>Shipping to and from anywhere</p>
                            <h1>FIND THE BEST FREIGHT QUOTE</h1>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="switcher">
                            <button id="freight-quote-btn" class="active">Freight Quotes</button>
                            <button id="container-tracking-btn">Container Tracking</button>
                        </div>

                        <form
                            id="freight-quote-form"
                            class="form active" method="POST"
                            action="{{ route('get_quote_step1') }}"
                            autocomplete="off"
                        >
                            @csrf
                            <input type="hidden" name="route_id" id="route_id" value="">
                            <input type="hidden" name="route_containers" id="route_containers" value="">
                            <input type="hidden" id="transportation_type"
                                   name="transportation_type" value="sea" required>
                            <div class="transport-type">
                                <button type="button" class="active transport-type-button">Ocean</button>
                                <span class="via-text">VIA</span>
                                <button type="button" class="transport-type-button">Air</button>
                            </div>
                            <div class="form-grid">
                                <div class="input-group">
                                    <label class="quotation-label">Origin of shipment</label>
                                    <select
                                        class="@error('origin_id') is-invalid @enderror"
                                        id="origin_id" name="origin_id"
                                        onchange="setDestinationAndRoute()" required>
                                        <option value="" disabled selected>Select
                                            Origin
                                        </option>
                                        @foreach($uniqueOrigins as $origin)
                                            <option value="{{ $origin['id'] }}"
                                                    data-destination="{{ $origin['destination_id'] }}"
                                                    data-route-id="{{ $origin['route_id'] }}"
                                                    data-containers="{{ $origin['containers'] }}"
                                                    data-all-destinations="{{ json_encode($destinations) }}"
                                            >{{ $origin['full_location'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group">
                                    <label class="quotation-label">Destination of shipment</label>
                                    <select
                                        class="@error('destination_id') is-invalid @enderror"
                                        id="destination_id" name="destination_id"
                                        onchange="setOriginAndRoute()" required>
                                        <option value="" disabled selected>Select
                                            Destination
                                        </option>
                                        @foreach($uniqueDestinations as $destination)
                                            <option value="{{ $destination['id'] }}"
                                                    data-origin="{{ $destination['origin_id'] }}"
                                                    data-route-id="{{ $destination['route_id'] }}"
                                                    data-containers="{{ $origin['containers'] }}"
                                                    data-all-origins="{{ json_encode($origins) }}"
                                            >{{ $destination['full_location'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group">
                                    <label class="quotation-label">Ready to load</label>
                                    <input name="date" type="date"
                                           data-date-format="dd-mm-yyyy" autocomplete="off"
                                           required id="ready_to_load_date">
                                </div>
                                <div class="input-group">
                                    <label class="quotation-label">Shipment type</label>
                                    <div class="custom-select">
                                        <div class="select-trigger">
                                            <span><i class="icon fad fa-truck-container"></i> FCL</span>
                                            <i class="arrow">^</i>
                                        </div>
                                        <ul class="select-options">
                                            <li class="option" data-value="fcl">
                                                <i class="icon fad fa-truck-container"></i>
                                                FCL
                                            </li>
                                        </ul>
                                        <input type="hidden" name="type" value="fcl">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="submit-button">QUOTE</button>
                        </form>

                        <form id="container-tracking-form" class="form" method="GET">
                            <div class="input-group">
                                <label class="quotation-label">Tracking number</label>
                                <input type="text" placeholder="Container Number/Code"/>
                            </div>
                            <div class="input-group">
                                <label class="quotation-label">Select sealine</label>
                                <input type="text" placeholder="Auto Detect"/>
                            </div>
                            <button type="submit" class="submit-button">Search</button>
                        </form>
                    </div>
                </div>
            </section>

            @include('frontend.index.benefits')
            <div class="wrapper-cookies">
                <div class="cookies">
                    <span class="cookies-text">
                        By using this website, you agree to <a target="_blank" href="#">our privacy policy</a>
                    </span>
                    <div class="cookies-button">
                        <a>OK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const selectTrigger = document.querySelector(".select-trigger");
        const selectOptions = document.querySelector(".select-options");
        const arrow = document.querySelector(".arrow");
        const options = document.querySelectorAll(".option");
        const hiddenInput = document.querySelector("input[name='type']");

        selectTrigger.addEventListener("click", () => {
            selectOptions.style.display = selectOptions.style.display === "block" ? "none" : "block";
            arrow.classList.toggle("open");
        });

        options.forEach(option => {
            option.addEventListener("click", () => {
                const selectedHTML = option.innerHTML;
                const selectedValue = option.dataset.value;
                const triggerSpan = selectTrigger.querySelector("span");

                triggerSpan.innerHTML = selectedHTML;
                hiddenInput.value = selectedValue;

                selectOptions.style.display = "none";
                arrow.classList.remove("open");
            });
        });

        document.addEventListener("click", (event) => {
            if (!event.target.closest(".custom-select")) {
                selectOptions.style.display = "none";
                arrow.classList.remove("open");
            }
        });
    </script>
    <script>
        //switching between forms
        const freightQuoteBtn = document.getElementById('freight-quote-btn');
        const containerTrackingBtn = document.getElementById('container-tracking-btn');
        const freightQuoteForm = document.getElementById('freight-quote-form');
        const containerTrackingForm = document.getElementById('container-tracking-form');

        freightQuoteBtn.addEventListener('click', () => {
            freightQuoteBtn.classList.add('active');
            containerTrackingBtn.classList.remove('active');
            freightQuoteForm.classList.add('active');
            containerTrackingForm.classList.remove('active');
        });

        containerTrackingBtn.addEventListener('click', () => {
            containerTrackingBtn.classList.add('active');
            freightQuoteBtn.classList.remove('active');
            containerTrackingForm.classList.add('active');
            freightQuoteForm.classList.remove('active');
        });
    </script>
    <script>
        function setOriginAndRoute() {
            const destinationSelect = document.getElementById('destination_id');
            const originSelect = document.getElementById('origin_id');
            const routeIdInput = document.getElementById('route_id');
            const selectedDestination = destinationSelect.options[destinationSelect.selectedIndex];
            let currentOrigin;

            if (!selectedDestination) return;

            // Parse all origins from the data attribute
            const allOrigins = JSON.parse(selectedDestination.dataset.allOrigins || '[]');
            const selectedOriginId = originSelect.value;

            // Check if any origin matches the selected destination's origin_id
            const matchingOrigins = allOrigins.filter(origin => origin.destination_id == selectedDestination.value);

            if (matchingOrigins.length > 0) {
                console.log('matching')

                // If a matching origin exists, keep the current selection if it's valid
                currentOrigin = matchingOrigins.find(origin => origin.id == selectedOriginId);
                if (!currentOrigin) {
                    console.log('no current')

                    originSelect.value = matchingOrigins[0].id;
                    currentOrigin = matchingOrigins[0];
                    console.log(currentOrigin)

                }
            } else {
                console.log('no matching')

                // If no matching origin exists, select the first option as default
                originSelect.value = '';
            }
            console.log(currentOrigin);

            // Update route_id and call container update if applicable
            routeIdInput.value = currentOrigin.route_id || '';
            updateContainerSelectOptions(selectedDestination.dataset.containers);
        }

        function setDestinationAndRoute() {
            const originSelect = document.getElementById('origin_id');
            const destinationSelect = document.getElementById('destination_id');
            const routeIdInput = document.getElementById('route_id');
            const selectedOrigin = originSelect.options[originSelect.selectedIndex];
            let currentDestination;

            if (!selectedOrigin) return;

            // Parse all destinations from the data attribute
            const allDestinations = JSON.parse(selectedOrigin.dataset.allDestinations || '[]');
            const selectedDestinationId = destinationSelect.value;

            // Check if any destination matches the selected origin's destination_id
            const matchingDestinations = allDestinations.filter(destination => destination.origin_id == selectedOrigin.value);

            if (matchingDestinations.length > 0) {
                console.log('matching')

                // If a matching destination exists, keep the current selection if it's valid
                currentDestination = matchingDestinations.find(destination => destination.id == selectedDestinationId);
                if (!currentDestination) {
                    console.log('no current')

                    destinationSelect.value = matchingDestinations[0].id; // Default to the first matching destination
                    currentDestination = matchingDestinations[0];

                }
            } else {
                console.log('no matching')

                // If no matching destination exists, select the first option as default
                destinationSelect.value = '';
            }
            console.log(currentDestination);

            // Update route_id and call container update if applicable
            routeIdInput.value = currentDestination.route_id || '';
            updateContainerSelectOptions(selectedOrigin.dataset.containers);
        }

        function updateContainerSelectOptions(dataArray) {
            document.getElementById('route_containers').value = dataArray;
        }
    </script>
@endsection
