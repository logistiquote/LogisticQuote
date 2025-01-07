<div class="tab-pane container-fluid active" role="tabpanel" id="step1">
    <input type="hidden" name="route_id" id="route_id" value="">
    @error('route_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
    <div class="row">
        <div class="col-sm-2 no-padding">Via</div>
        <div class="col-sm-2 no-padding">Origin *</div>
        <div class="col-sm-2 no-padding">Destination *</div>
        <div class="col-sm-2 no-padding">Ready to Load *</div>
        <div class="col-sm-2 no-padding">Type of Shipment *</div>
    </div>
    <div class="row quote-form">
        <div class="col-sm-2 no-padding">
            <input type="hidden" id="transportation_type" name="transportation_type" value="ocean" />
            <button class="btn-blue">
               <span class="icon-container">
                   <i class="fad fa-ship fa-2x"></i>
               </span>
                <span class="text-container">
                    OCEAN FREIGHT
                </span>
            </button>
        </div>
        <div class="col-sm-2 no-padding">
            <select class="custom-block-padding full-width full-height no-border custom-default-font" id="origin_id" name="origin_id"
                    onchange="setDestinationAndRoute()">
                <option value="" disabled selected>Select Origin</option>
                @foreach($origins as $origin)
                    <option value="{{ $origin['id'] }}" data-destination="{{ $origin['destination_id'] }}"
                            data-containers="{{$origin['containers']}}"
                            data-route-id="{{ $origin['route_id'] }}">
                        {{ $origin['full_location'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2 no-padding">
            <select class="custom-block-padding full-width full-height no-border custom-default-font" id="destination_id" name="destination_id"
                    onchange="setOriginAndRoute()">
                <option value="" disabled selected>Select Destination</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination['id'] }}" data-origin="{{ $destination['origin_id'] }}"
                            data-containers="{{$destination['containers']}}"
                            data-route-id="{{ $destination['route_id'] }}">
                        {{ $destination['full_location'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2 no-padding">
            <input type="date" class="custom-block-padding full-width full-height no-border custom-default-font" name="ready_to_load_date"
                   id="ready_to_load_date" required min="{{ date('Y-m-d') }}">
            @error('ready_to_load_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-sm-2 no-padding">
            <div class="custom-dropdown custom-block-padding full-width full-height no-border custom-default-font">
                <input type="hidden" id="type_of_shipment" name="type" value="fcl" />
                <div class="dropdown-selected full-height" id="selectedOption">
                    <i class="fad fa-truck-container mr-2 icon-font-size"></i> FCL
                </div>
                <div class="dropdown-options" id="dropdownOptions">
                    <div class="dropdown-option" data-value="fcl">
                        <i class="fad fa-truck-container mr-2 icon-font-size"></i> FCL
                    </div>
                    <div class="dropdown-option" data-value="lcl">
                        <i class="fad fa-truck-loading mr-2 icon-font-size"></i> LCL
                    </div>
                </div>
            </div>
            @error('type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-sm-2 no-padding">
            <button type="button" class="quote-btn next-step step1 full-height full-width">Next step</button>
        </div>
    </div>
</div>
<script>
    const selectedOption = document.getElementById('selectedOption');
    const dropdownOptions = document.getElementById('dropdownOptions');
    const typeOfShipment = document.getElementById('type_of_shipment');
    selectedOption.addEventListener('click', () => {
        dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
    });

    dropdownOptions.addEventListener('click', (e) => {
        if (e.target.closest('.dropdown-option')) {
            const option = e.target.closest('.dropdown-option');
            const icon = option.querySelector('i').outerHTML;
            const value = option.dataset.value;

            selectedOption.innerHTML = `${icon} ${option.textContent.trim()}`;

            typeOfShipment.value = value;

            if(value === 'fcl'){
                $('#for_fcl').show();
                $('#for_lcl').hide();
            }else{
                $('#for_fcl').hide();
                $('#for_lcl').show();
            }
            dropdownOptions.style.display = 'none';
        }
    });
</script>
<script>
    // Additional validation logic or utilities for this step
    document.addEventListener('DOMContentLoaded', function () {
        const nextStepButton = document.querySelector('.step1');
        if(document.getElementById('type_of_shipment').value === 'fcl'){
            $('#for_fcl').show();
            $('#for_lcl').hide();
        }else{
            $('#for_fcl').hide();
            $('#for_lcl').show();
        }

        if (nextStepButton) {
            nextStepButton.addEventListener('click', function (event) {
                const fields = [
                    {name: 'route_id', required: true, label: 'Route'},
                    {name: 'type', required: true, label: 'Type of Shipment'},
                    {name: 'ready_to_load_date', required: true, label: 'Ready to Load Date'}
                ];

                let isValid = true;

                // Clear previous errors
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.error-message').forEach(el => el.remove());

                fields.forEach(field => {
                    const input = document.querySelector(`[name="${field.name}"]`);
                    if (!input || !input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        const errorElement = document.createElement('div');
                        errorElement.className = 'error-message text-danger';
                        errorElement.textContent = `${field.label} is required.`;
                        input.parentNode.appendChild(errorElement);
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                }
            });
        }
    });

    // Pre-fill dependent fields based on selection
    function setDestinationAndRoute() {
        const originSelect = document.getElementById('origin_id');
        const destinationSelect = document.getElementById('destination_id');
        const routeIdInput = document.getElementById('route_id');
        const selectedOrigin = originSelect.options[originSelect.selectedIndex];

        // Update destination based on the selected origin
        if (selectedOrigin && selectedOrigin.dataset.destination) {
            const destinationValue = selectedOrigin.dataset.destination;
            Array.from(destinationSelect.options).forEach(option => {
                option.selected = option.value === destinationValue;
            });
        }

        // Set the route_id hidden input
        if (selectedOrigin && selectedOrigin.dataset.routeId) {
            routeIdInput.value = selectedOrigin.dataset.routeId;
            updateContainerSelectOptions(selectedOrigin.dataset.containers)
        }
    }

    function setOriginAndRoute() {
        const destinationSelect = document.getElementById('destination_id');
        const originSelect = document.getElementById('origin_id');
        const routeIdInput = document.getElementById('route_id');
        const selectedDestination = destinationSelect.options[destinationSelect.selectedIndex];

        // Update origin based on the selected destination
        if (selectedDestination && selectedDestination.dataset.origin) {
            const originValue = selectedDestination.dataset.origin;
            Array.from(originSelect.options).forEach(option => {
                option.selected = option.value === originValue;
            });
        }

        // Set the route_id hidden input
        if (selectedDestination && selectedDestination.dataset.routeId) {
            routeIdInput.value = selectedDestination.dataset.routeId;
            updateContainerSelectOptions(selectedDestination.dataset.containers)
        }
    }

    function updateContainerSelectOptions(dataArray){
        const select = document.getElementById('inlineFormCustomSelect');

        while (select.options.length > 1) {
            select.remove(1);
        }
        if (typeof dataArray === 'string') {
            dataArray = JSON.parse(dataArray);
        }

        dataArray.forEach(item => {
            const option = document.createElement('option');
            option.value = item.container_type;
            option.textContent = `${item.container_type} - $${item.price}`;

            select.appendChild(option);
        });
    }
</script>
