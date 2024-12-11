<div class="tab-panel" role="tabpanel" id="step3">
    <h4 class="text-center">Shipment Calculations</h4>
    <hr>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="custom-control custom-radio custom-control-inline">
                <div id="if_not_air">
                    <label class="custom-control-label" for="customRadioInline1">Calculate
                        by total shipment
                    </label>
                    <input type="radio" id="customRadioInline1" name="calculate_by"
                           value="shipment" class="custom-control-input">
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="custom-control custom-radio custom-control-inline">
                <label class="custom-control-label" for="customRadioInline2">Calculate
                    by units *</label>
                <input type="radio" id="customRadioInline2" name="calculate_by" required
                       value="units" class="custom-control-input" checked>
            </div>
        </div>
    </div>

    <div id="shipment">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="">Quantity</label>
                <input type="number"
                       class="form-control @error('quantity') is-invalid @enderror"
                       id="validationServer03" placeholder="Quantity" name="quantity"
                       value="{{ old('quantity') }}">
                @error('quantity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="">Gross Weight</label>
                <input type="number"
                       class="form-control @error('total_weight') is-invalid @enderror"
                       id="validationServer04" placeholder="Gross Weight" name="total_weight"
                       value="{{ old('total_weight') }}">
                @error('total_weight')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div id="dynamic_fields">
            <div class="form-row dynamic-field" style="margin: 20px 0px 10px 0px;"
                 id="units-1">
                <label for="" style="font-weight: bold;">Pallet#1</label>
                <!-- <label for="">Dimensions (cm)</label> -->
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="">Length (cm)</label>
                        <input type="number"
                               class="form-control @error('l') is-invalid @enderror"
                               id="validationServer04" placeholder="length" name="l[]">
                        @error('l')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="">Width (cm)</label>
                        <input type="number"
                               class="form-control @error('w') is-invalid @enderror"
                               id="validationServer03" placeholder="width" name="w[]">
                        @error('w')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="">Height (cm)</label>
                        <input type="number"
                               class="form-control @error('h') is-invalid @enderror"
                               id="validationServer03" placeholder="height" name="h[]">
                        @error('h')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3 ml-3">
                        <label for="">Gross Weight (kg)</label>
                        <input type="number"
                               class="form-control @error('gross_weight') is-invalid @enderror"
                               id="validationServer03" placeholder="weight"
                               name="gross_weight[]">
                        @error('gross_weight')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3 ml-3">
                        <label for="">Vol Weight (kg)</label>
                        <input type="number"
                               class="form-control @error('total_weight_units') is-invalid @enderror"
                               id="validationServer03" placeholder="weight"
                               name="total_weight_units[]" disabled>
                        @error('total_weight_units')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="form-row" id="dynamic_buttons">
            <button type="button" class="btn btn-primary btn-sm" id="add-button"
                    style="padding: 0px 6px 0px 13px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                <!-- <span>Add New</span> -->
                <i class="fal fa-plus"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" id="remove-button"
                    style="padding: 0px 6px 0px 13px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                <!-- <span>Add New</span> -->
                <i class="fal fa-minus"></i>
            </button>
        </div>
    </div>

    <ul class="list-inline pull-right">
        <li><button type="button" class="default-btn prev-step">Back</button></li>
        <li><button type="button" class="default-btn next-step step3">Continue</button>
        </li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nextStepButton = document.querySelector('.step3');

        if (nextStepButton) {
            nextStepButton.addEventListener('click', function (event) {
                let isValid = true;

                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                // Validate the `calculate_by` field
                const calculateByField = document.querySelector('[name="calculate_by"]:checked');
                if (!calculateByField) {
                    isValid = false;
                    displayError(document.querySelector('[name="calculate_by"]'), 'Please select a calculation method.');
                }

                // Validation for "Calculate by Shipment"
                if (calculateByField && calculateByField.value === 'shipment') {
                    const quantityField = document.querySelector('[name="quantity"]');
                    const totalWeightField = document.querySelector('[name="total_weight"]');

                    if (!quantityField.value.trim()) {
                        isValid = false;
                        displayError(quantityField, 'Quantity is required.');
                    }

                    if (!totalWeightField.value.trim() || isNaN(totalWeightField.value) || totalWeightField.value <= 0) {
                        isValid = false;
                        displayError(totalWeightField, 'Total Weight must be a valid number greater than 0.');
                    }
                }

                // Validation for "Calculate by Units"
                if (calculateByField && calculateByField.value === 'units') {
                    const lengthFields = document.querySelectorAll('[name="l[]"]');
                    const widthFields = document.querySelectorAll('[name="w[]"]');
                    const heightFields = document.querySelectorAll('[name="h[]"]');
                    const grossWeightFields = document.querySelectorAll('[name="gross_weight[]"]');

                    lengthFields.forEach((field, index) => {
                        if (!field.value.trim() || isNaN(field.value) || field.value <= 0) {
                            isValid = false;
                            displayError(field, `Length for Pallet #${index + 1} must be a valid number greater than 0.`);
                        }
                    });

                    widthFields.forEach((field, index) => {
                        if (!field.value.trim() || isNaN(field.value) || field.value <= 0) {
                            isValid = false;
                            displayError(field, `Width for Pallet #${index + 1} must be a valid number greater than 0.`);
                        }
                    });

                    heightFields.forEach((field, index) => {
                        if (!field.value.trim() || isNaN(field.value) || field.value <= 0) {
                            isValid = false;
                            displayError(field, `Height for Pallet #${index + 1} must be a valid number greater than 0.`);
                        }
                    });

                    grossWeightFields.forEach((field, index) => {
                        if (!field.value.trim() || isNaN(field.value) || field.value <= 0) {
                            isValid = false;
                            displayError(field, `Gross Weight for Pallet #${index + 1} must be a valid number greater than 0.`);
                        }
                    });
                }

                // Prevent navigation if validation fails
                if (!isValid) {
                    alert('Please fix the errors before proceeding to the next step.');
                    event.preventDefault();
                    event.stopImmediatePropagation(); // Stop other click handlers from executing

                }
            });
        }

        /**
         * Display an error message below a field
         * @param {HTMLElement} field - The field to display an error for
         * @param {string} message - The error message
         */
        function displayError(field, message) {
            console.log('3')
            field.classList.add('is-invalid');
            const errorElement = document.createElement('div');
            errorElement.className = 'error-message text-danger';
            errorElement.textContent = message;
            field.parentNode.appendChild(errorElement);
        }
    });
</script>

