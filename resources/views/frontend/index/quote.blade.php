@php
    $uniqueOrigins = collect($origins)->unique('full_location');
    $uniqueDestinations = collect($destinations)->unique('full_location');
@endphp
<div class="transport-type mb-3">
    <button type="button" class="active transport-type-button" data-type="ocean">Ocean</button>
    <span class="via-text">VIA</span>
    <button type="button" class="transport-type-button" data-type="air">Air</button>
</div>
<form
    id="freight-quote-form-ocean"
    class="form active" method="POST"
    action="{{ route('get_quote_step1') }}"
    autocomplete="off"
>
    @csrf
    <input type="hidden" name="route_id" id="route_id" value="">
    <input type="hidden" name="route_containers" id="route_containers" value="">
    <input type="hidden" id="transportation_type" name="transportation_type" value="sea">

    <div>
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
                       required id="ready_to_load_date"
                       min="<?= date('Y-m-d'); ?>"
                >
            </div>
            <div class="input-group">
                <label class="quotation-label">Shipment type</label>
                <div class="custom-select" style="padding: 10px">
                    <div class="select-trigger">
                        <span><i class="icon fad fa-truck-container"></i> FCL</span>
                        <i class="arrow">^</i>
                    </div>
                    <ul class="select-options">
                        <li class="option" data-value="fcl">
                            <i class="icon fad fa-truck-container"></i>
                            FCL
                        </li>
                        <li class="option" data-value="lcl">
                            <i class="icon fas fa-dolly"></i>
                            LCL
                        </li>
                    </ul>
                    <input type="hidden" name="type" value="fcl">
                </div>
            </div>
        </div>
    </div>
    <button type="submit" id="quote-submit" class="submit-button">QUOTE</button>
</form>
@if(env('APP_ENV') === 'production')
    <div class="form-grid" id="freight-quote-form-air" style="text-align: center">
        <p>Coming Soon</p>
    </div>
@else
    <form
        id="freight-quote-form-air"
        class="form active" method="POST"
        action="{{ route('dhl.quote-formation') }}"
        style="display: none;"
        autocomplete="off"
    >
        @csrf
        <div class="form-grid">
            <!-- Origin Details -->
            <div class="input-group">
                <label class="quotation-label" for="origin_country">Origin Country</label>
                <input
                    type="text"
                    class="@error('origin_country') is-invalid @enderror"
                    id="origin_country" name="origin_country"
                    placeholder="Enter origin country" required>
            </div>
            <div class="input-group">
                <label class="quotation-label" for="origin_postal">Origin Postal Code</label>
                <input
                    type="text"
                    class="@error('origin_postal') is-invalid @enderror"
                    id="origin_postal" name="origin_postal"
                    placeholder="Enter origin postal code" required>
            </div>

            <!-- Destination Details -->
            <div class="input-group">
                <label class="quotation-label" for="destination_country">Destination
                    Country</label>
                <input
                    type="text"
                    class="@error('destination_country') is-invalid @enderror"
                    id="destination_country" name="destination_country"
                    placeholder="Enter destination country" required>
            </div>
            <div class="input-group">
                <label class="quotation-label" for="destination_postal">Destination Postal
                    Code</label>
                <input
                    type="text"
                    class="@error('destination_postal') is-invalid @enderror"
                    id="destination_postal" name="destination_postal"
                    placeholder="Enter destination postal code" required>
            </div>
        </div>
        <button type="submit" id="quote-submit" class="submit-button">QUOTE</button>
    </form>
@endif
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
            // If a matching origin exists, keep the current selection if it's valid
            currentOrigin = matchingOrigins.find(origin => origin.id == selectedOriginId);
            if (!currentOrigin) {
                originSelect.value = matchingOrigins[0].id;
                currentOrigin = matchingOrigins[0];
            }
        } else {
            // If no matching origin exists, select the first option as default
            originSelect.value = '';
        }

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
            // If a matching destination exists, keep the current selection if it's valid
            currentDestination = matchingDestinations.find(destination => destination.id == selectedDestinationId);
            if (!currentDestination) {
                destinationSelect.value = matchingDestinations[0].id; // Default to the first matching destination
                currentDestination = matchingDestinations[0];
            }
        } else {
            // If no matching destination exists, select the first option as default
            destinationSelect.value = '';
        }
        // Update route_id and call container update if applicable
        routeIdInput.value = currentDestination.route_id || '';
        updateContainerSelectOptions(selectedOrigin.dataset.containers);
    }

    function updateContainerSelectOptions(dataArray) {
        document.getElementById('route_containers').value = dataArray;
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const transportButtons = document.querySelectorAll(".transport-type-button");
        const oceanForm = document.getElementById("freight-quote-form-ocean");
        const airForm = document.getElementById("freight-quote-form-air");

        transportButtons.forEach(button => {
            button.addEventListener("click", function () {
                transportButtons.forEach(btn => btn.classList.remove("active"));

                this.classList.add("active");

                const transportType = this.getAttribute("data-type");

                if (transportType === "ocean") {
                    oceanForm.style.display = "grid";
                    airForm.style.display = "none";
                } else if (transportType === "air") {
                    airForm.style.display = "grid";
                    oceanForm.style.display = "none";
                }
            });
        });
    });

</script>
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
