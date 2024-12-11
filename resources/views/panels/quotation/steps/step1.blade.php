<div class="tab-panel active" role="tabpanel" id="step1">
    <h4 class="text-center">Basic Info</h4>
    <hr>
    <div class="row">

        <div class="col-md-6">
            <label>Origin *</label>
        </div>
        <div class="col-md-12 form-row">
            <div class="col-md-3 mb-3">
                <input type="text"
                       class="form-control @error('origin_city') is-invalid @enderror"
                       id="validationServer03" placeholder="City"
                       value="{{ old('origin_city') }}" name="origin_city" required>
                @error('origin_city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
                <input type="text"
                       class="form-control @error('origin_state') is-invalid @enderror"
                       id="validationServer04" placeholder="State" name="origin_state"
                       value="{{ old('origin_state') }}">
                @error('origin_state')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
                <input type="text"
                       class="form-control @error('origin_country') is-invalid @enderror"
                       id="validationServer03" placeholder="Country" name="origin_country" required
                       value="{{ old('origin_country') }}">
                @error('origin_country')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 mb-3">
                <input type="text"
                       class="form-control @error('origin_zip') is-invalid @enderror"
                       id="validationServer05" placeholder="Zip" name="origin_zip" required
                       value="{{ old('origin_zip') }}">
                @error('origin_zip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <label>Destination *</label>
        </div>
        <div class="col-md-12 form-row">
            <div class="col-md-3 mb-3">
                <input type="text"
                       class="form-control @error('destination_city') is-invalid @enderror"
                       id="validationServer03" placeholder="City" name="destination_city" required
                       value="{{ old('destination_city') }}">
                @error('destination_city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
                <input type="text"
                       class="form-control @error('destination_state') is-invalid @enderror"
                       id="validationServer04" placeholder="State" name="destination_state"
                       value="{{ old('destination_state') }}">
                @error('destination_state')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
                <input type="text"
                       class="form-control @error('destination_country') is-invalid @enderror"
                       id="validationServer03" placeholder="Country" name="destination_country" required
                       value="{{ old('destination_country') }}">
                @error('destination_country')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 mb-3">
                <input type="text"
                       class="form-control @error('destination_zip') is-invalid @enderror"
                       id="validationServer05" placeholder="Zip" name="destination_zip" required
                       value="{{ old('destination_zip') }}">
                @error('destination_zip')
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
        const nextStepButton = document.querySelector('.step');

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
</script>

