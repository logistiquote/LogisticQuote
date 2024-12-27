<div class="tab-panel active" role="tabpanel" id="step1">
    <h4 class="text-center">Basic Info</h4>
    <hr>
    <div class="row">

        <div class="col-md-6">
            <label>Route *</label>
        </div>
        <div class="col-md-12 form-row">
            <div class="col-md-6 mb-3">
                <label for="origin_id">Origin</label>
                <select class="form-control @error('origin_id') is-invalid @enderror" id="origin_id" name="origin_id" onchange="setDestination()">
                    <option value="" disabled selected>Select Origin</option>
                    @foreach($origins as $origin)
                        <option value="{{ $origin['id'] }}" data-destination="{{ $origin['destination_id'] }}">{{ $origin['full_location'] }}</option>
                    @endforeach
                </select>
                @error('origin_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="destination_id">Destination</label>
                <select class="form-control @error('destination_id') is-invalid @enderror" id="destination_id" name="destination_id" onchange="setOrigin()">
                    <option value="" disabled selected>Select Destination</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination['id'] }}" data-origin="{{ $destination['origin_id'] }}">{{ $destination['full_location'] }}</option>
                    @endforeach
                </select>
                @error('destination_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>


        <div class="col-md-4 mb-3">
            <label for="validationServer01">Ready to load date *</label>
            <input type="date"
                   class="form-control @error('ready_to_load_date') is-invalid @enderror"
                   name="ready_to_load_date" value="{{ old('ready_to_load_date') }}" required />
            @error('ready_to_load_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-9 mb-3">
            <label for="exampleFormControlTextarea1">Description of goods</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                      name="description_of_goods">{{ old('description_of_goods') }}</textarea>
            @error('description_of_goods')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

    </div>
    <ul class="list-inline pull-right">
        <li>
            <button type="button" class="default-btn next-step step1">Continue to next
                step</button>
        </li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nextStepButton = document.querySelector('.step1');

        if (nextStepButton) {
            nextStepButton.addEventListener('click', function (event) {
                // Validation logic
                const fields = [
                    { name: 'origin_city', required: true, regex: /^[a-zA-Z\s\-]+$/, maxLength: 100, label: 'Origin City', message: 'Enter a valid city name (letters, spaces, and dashes only, max 100 characters).' },
                    { name: 'origin_country', required: true, regex: /^[A-Z]{2}$/, label: 'Origin Country', message: 'Enter a valid 2-letter country code (e.g., US, GB).' },
                    { name: 'origin_zip', required: true, regex: /^\d{4,10}$/, label: 'Origin ZIP', message: 'Enter a valid ZIP code (4-10 digits).' },
                    { name: 'destination_city', required: true, regex: /^[a-zA-Z\s\-]+$/, maxLength: 100, label: 'Destination City', message: 'Enter a valid city name (letters, spaces, and dashes only, max 100 characters).' },
                    { name: 'destination_country', required: true, regex: /^[A-Z]{2}$/, label: 'Destination Country', message: 'Enter a valid 2-letter country code (e.g., US, GB).' },
                    { name: 'destination_zip', required: true, regex: /^\d{4,10}$/, label: 'Destination ZIP', message: 'Enter a valid ZIP code (4-10 digits).' },
                    { name: 'ready_to_load_date', required: true, type: 'date', label: 'Ready to Load Date', message: 'Enter a valid date not earlier than today.' }
                ];

                let isValid = true;

                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                fields.forEach(field => {
                    const input = document.querySelector(`[name="${field.name}"]`);
                    if (input) {
                        const value = input.value.trim();
                        let errorMessage = '';

                        // Validation for required fields
                        if (field.required && !value) {
                            errorMessage = `${field.label} is required.`;
                        }

                        // Validation for regex pattern
                        if (!errorMessage && field.regex && !field.regex.test(value)) {
                            errorMessage = field.message;
                        }

                        // Validation for string length
                        if (!errorMessage && field.maxLength && value.length > field.maxLength) {
                            errorMessage = field.message;
                        }

                        // Validation for dates
                        if (!errorMessage && field.type === 'date') {
                            const today = new Date().toISOString().split('T')[0];
                            if (new Date(value) < new Date(today)) {
                                errorMessage = field.message;
                            }
                        }

                        if (errorMessage) {
                            isValid = false;
                            console.log('1');
                            // Add error class and message
                            input.classList.add('is-invalid');
                            const errorElement = document.createElement('div');
                            errorElement.className = 'error-message text-danger';
                            errorElement.textContent = errorMessage;
                            input.parentNode.appendChild(errorElement);
                        }
                    }
                });

                // Prevent default action if validation fails
                if (!isValid) {
                    alert('Please fix the errors before proceeding to the next step.');
                    event.preventDefault(); // Prevent default behavior
                    event.stopImmediatePropagation(); // Stop other click handlers from executing
                }
            }, true); // Use the "capture" phase to give this handler higher priority
        }
    });

    function setDestination() {
        const originSelect = document.getElementById('origin_id');
        const destinationSelect = document.getElementById('destination_id');
        const selectedOrigin = originSelect.options[originSelect.selectedIndex];

        if (selectedOrigin && selectedOrigin.dataset.destination) {
            const destinationValue = selectedOrigin.dataset.destination;
            Array.from(destinationSelect.options).forEach(option => {
                option.selected = option.value === destinationValue;
            });
        }
    }

    function setOrigin() {
        const destinationSelect = document.getElementById('destination_id');
        const originSelect = document.getElementById('origin_id');
        const selectedDestination = destinationSelect.options[destinationSelect.selectedIndex];

        if (selectedDestination && selectedDestination.dataset.origin) {
            const originValue = selectedDestination.dataset.origin;
            Array.from(originSelect.options).forEach(option => {
                option.selected = option.value === originValue;
            });
        }
    }

</script>

