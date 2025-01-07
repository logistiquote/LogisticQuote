<div class="tab-pane" role="tabpanel" id="step2">
    <h4 class="bold default-black-font">Description of Goods</h4>
    <div class="row">

        <div class="col-md-6">
            <label class="mr-sm-2 bold" for="incoterms">Incoterms *</label>
            <select class="custom-select mr-sm-2 @error('incoterms') is-invalid @enderror"
                    id="incoterms" name="incoterms" value="{{ old('incoterms') }}" required>
                <option value="" selected>Choose..</option>
                <option value="EXW">EXW (Ex Works Place)</option>
                <option value="FOB">FOB (Free On Board Port)</option>
                <option value="CIP/CIF">CIF/CIP (Cost Insurance & Freight / Carriage &
                    Insurance Paid)
                </option>
                <option value="DAP">DAP (Delivered At Place)</option>
            </select>
            @error('incoterms')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div id="exw">
        <div class="row py-3">
            <div class="col-md-6">
                <label class="bold" for="validationServer01">Pick Up Address</label>
                <input
                    type="text"
                    class="form-control"
                    name="pickup_address"
                    placeholder="Pick Up Address"
                    value="{{ old('pickup_address') }}"
                />
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-6">
                <label class="bold" for="validationServer01">
                    Final destination address
                </label>
                <input
                    type="text"
                    class="form-control"
                    name="destination_address"
                    placeholder="Final destination address"
                    value="{{ old('destination_address') }}"
                />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 my-3">
            <label class="bold" for="value_of_goods">Value of Goods *</label>
            <input id="validationServer03"
                   type="number"
                   class="form-control @error('value_of_goods') is-invalid @enderror"
                   placeholder="Value of Goods (USD)"
                   name="value_of_goods"
                   value="{{ old('value_of_goods') }}"
                   required
            >
            @error('value_of_goods')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 my-3">
            <label for="description_of_goods" class="bold">
                Description of Goods
            </label>
            <textarea
                id="description_of_goods"
                class="form-control"
                rows="3"
                name="description_of_goods"
                style="resize: none"
            >
                {{ old('description_of_goods') }}
            </textarea>
            @error('description_of_goods')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <!-- Dynamic Containers -->

    <div id="for_fcl">
        <div class="row" id="dynamic_containers">

            <div class="col-md-12">
                <label class="mt-3 bold">Containers Specification</label>
            </div>

            <div class="dynamic-container row col-md-12" style="margin: 20px 0 10px 0;"
                 id="container-1">
                <label for="" style="font-weight: bold;">Container#1</label>
                <div class="col-md-5 mb-3">
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                            name="container_size[]">
                        <option value="" disabled selected>Select Container</option>
                    </select>
                    @error('container_size')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <input type="number"
                           class="form-control @error('container_weight') is-invalid @enderror"
                           id="validationServer03" placeholder="Weight (kg)"
                           name="container_weight[]" value="{{ old('container_weight.0') }}">
                    @error('gross_weight')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row" id="dynamic_btn">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-sm custom-dynamic-btn" id="add_container">
                    <i class="fal fa-plus"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm custom-dynamic-btn" id="remove_container">
                    <i class="fal fa-minus"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="for_lcl">
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
        <div class="row" id="dynamic_btn">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-sm custom-dynamic-btn" id="add_container">
                    <i class="fal fa-plus"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm custom-dynamic-btn" id="remove_container">
                    <i class="fal fa-minus"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="form-row my-3">
        <div class="col-md-3 mb-3">
            <div class="col-auto my-1">
                <label>Is Stockable?</label>
                <div class="toggle-switch">
                    <input type="checkbox" id="stockableToggle" name="is_stockable" value="0">

                    <label for="stockableToggle" class="toggle-switch-label">
                        <span class="toggle-option active">NO</span>
                        <span class="toggle-option">YES</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="col-auto my-1">
                <label>Is DGR?</label>
                <div class="toggle-switch">
                    <input type="checkbox" id="dgrToggle" name="is_dgr" value="0">

                    <label for="dgrToggle" class="toggle-switch-label">
                        <span class="toggle-option active">NO</span>
                        <span class="toggle-option">YES</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h4 class="bold default-black-font">Other Info</h4>
        <div class="all-info-container">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="exampleFormControlTextarea1">Remarks</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                              name="remarks">{{ old('remarks') }}</textarea>
                    @error('remarks')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="hidden" name="is_clearance_req" value="0">
                        <input type="checkbox" class="custom-control-input"
                               id="customControlAutosizing3" name="is_clearance_req" value="1">
                        <label class="custom-control-label" for="customControlAutosizing3">
                            Customs Clearance?</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="hidden" name="insurance" value="0">
                        <input type="checkbox" class="custom-control-input"
                               id="customControlAutosizing4" name="insurance" value="1">
                        <label class="custom-control-label" for="customControlAutosizing4">
                            Goods Isurance</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Attach a file</label>
                        <input type="file" style="border: 1px solid grey; border-radius: 5px; padding: 10px;" class="form-control-file" name="attachment" id="exampleFormControlFile1">
                    </div>
                </div>
            </div>
    </div>

    <ul class="list-inline pull-right">
        <li><button type="button" class="default-btn prev-step">Back</button></li>
        <li><button type="button" class="default-btn next-step step2">Continue</button>
        </li>
    </ul>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggles = document.querySelectorAll(".toggle-switch");

        toggles.forEach(toggle => {
            const input = toggle.querySelector("input[type='checkbox']");
            const options = toggle.querySelectorAll(".toggle-option");

            input.addEventListener("change", () => {
                if (input.checked) {
                    input.value = "1";
                    options[0].classList.remove("active");
                    options[1].classList.add("active");
                } else {
                    input.value = "0";
                    options[1].classList.remove("active");
                    options[0].classList.add("active");
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nextStepButton = document.querySelector('.step2');

        if (nextStepButton) {
            nextStepButton.addEventListener('click', function (event) {
                // Define fields and validation rules
                const fields = [
                    {
                        name: 'incoterms',
                        required: true,
                        label: 'Incoterms',
                        message: 'Please select a valid Incoterm.'
                    },
                    {
                        name: 'value_of_goods',
                        required: true,
                        type: 'number',
                        min: 1,
                        max: 9999999,
                        label: 'Value of Goods',
                        message: 'Enter a value between 1 and 9,999,999 USD.'
                    },
                    {
                        name: 'transportation_type',
                        required: true,
                        label: 'Transportation Type',
                        message: 'Please select a transportation type.'
                    },
                    {
                        name: 'type',
                        required: true,
                        label: 'Type of Shipment',
                        message: 'Please select a type of shipment.'
                    }
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

                        // Validation for number range
                        if (!errorMessage && field.type === 'number') {
                            const numValue = parseFloat(value);
                            if (isNaN(numValue) || numValue < field.min || numValue > field.max) {
                                errorMessage = field.message;
                            }
                        }

                        if (errorMessage) {
                            isValid = false;

                            // Add error class and message
                            input.classList.add('is-invalid');
                            const errorElement = document.createElement('div');
                            errorElement.className = 'error-message text-danger';
                            errorElement.textContent = errorMessage;
                            input.parentNode.appendChild(errorElement);
                        }
                    }
                });

                // Prevent moving to the next step if validation fails
                if (!isValid) {
                    alert('Please fix the errors before proceeding to the next step.');
                    event.preventDefault();
                    event.stopImmediatePropagation(); // Stop other click handlers from executing
                }
            });
        }
    });
</script>

