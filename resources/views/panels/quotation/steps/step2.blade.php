<div class="tab-panel" role="tabpanel" id="step2">
    <h4 class="text-center">Description of Goods</h4>
    <hr>
    <div class="row">

        <div class="col-md-6">
            <label class="mr-sm-2" for="incoterms">Incoterms *</label>
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
                <label for="validationServer01">Pick Up Address</label>
                <input type="text" class="form-control" name="pickup_address"
                       value="{{ old('pickup_address') }}" />
            </div>

            <div class="col-md-6">
                <label for="validationServer01">Final destination address</label>
                <input type="text" class="form-control" name="destination_address"
                       value="{{ old('destination_address') }}" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 my-3">
            <label for="">Value of Goods *</label>
            <input type="number"
                   class="form-control @error('value_of_goods') is-invalid @enderror"
                   id="validationServer03" placeholder="Value of Goods (USD)"
                   name="value_of_goods" value="{{ old('value_of_goods') }}" required>
            @error('value_of_goods')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-auto my-1">
            <label class="mr-sm-2" for="transportation_type">Transportation Type *</label>
            <select
                class="custom-select mr-sm-2 @error('transportation_type') is-invalid @enderror"
                id="transportation_type" name="transportation_type" required>
                <option value="" selected>Choose...</option>
                <option value="ocean">Ocean Freight</option>
                <option value="air">Air Freight</option>
            </select>
            @error('transportation_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-auto my-1">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Type of Shipment *</label>
            <select class="custom-select mr-sm-2 @error('type') is-invalid @enderror"
                    id="type_of_shipment" name="type" required>
                <option value="" selected>Choose...</option>
            </select>
            @error('type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <!-- Dynamic Containers -->

    <div id="for_flc">
        <div class="row" id="dynamic_containers">

            <div class="col-md-12">
                <label class="mt-3">Containers Specification</label>
            </div>

            <div class="dynamic-container row" style="margin: 20px 0px 10px 0px;"
                 id="container-1">
                <label for="" style="font-weight: bold;">Container#1</label>
                <div class="col-md-5 mb-3">
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                            name="container_size[]">
                        <option selected="">Container size</option>
                        <option value="20f-dc">20' Dry Cargo</option>
                        <option value="40f-dc">40' Dry Cargo</option>
                        <option value="40f-hdc">40' add-high Dry Cargo</option>
                        <option value="45f-hdc">45' add-high Dry Cargo</option>
                        <option value="20f-ot">20' Open Top</option>
                        <option value="40f-ot">40' Open Top</option>
                        <option value="20f-col">20' Collapsible</option>
                        <option value="40f-col">40' Collapsible</option>
                        <option value="20f-os">20' Open Side</option>
                        <option value="20f-dv">20' D.V for Side Floor</option>
                        <option value="20f-ven">20' Ventilated</option>
                        <option value="40f-gar">40' Garmentainer</option>
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
                <button type="button" class="btn btn-primary btn-sm" id="add_container"
                        style="padding: 0px 6px 0px 13px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                    <!-- <span>Add New</span> -->
                    <i class="fal fa-plus"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="remove_container"
                        style="padding: 0px 6px 0px 13px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                    <!-- <span>Add New</span> -->
                    <i class="fal fa-minus"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="form-row my-3">
        <div class="col-md-3 mb-3">
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="hidden" name="is_stockable" value="0">
                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="is_stockable" value="1">
                    <label class="custom-control-label" for="customControlAutosizing">Is
                        Stockable</label>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="hidden" name="is_dgr" value="0">
                    <input type="checkbox" class="custom-control-input"
                           id="customControlAutosizing2" name="is_dgr" value="1">
                    <label class="custom-control-label" for="customControlAutosizing2">Is
                        DGR</label>
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
                            console.log('2');

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

