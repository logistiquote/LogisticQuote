<div class="main-content mt-5">
    <div class="container">
        <div class="form-container" style="text-align: left">
            <form class="form active contact-us-form" action="{{ route('frontend.quote_final_step') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                <h3 class="section-title">Delivery info</h3>

                <div class="form-grid">
                    <div class="input-group">
                        <label class="quotation-label">Incoterms</label>
                        <select name="incoterms" required="" id="incoterms">
                            <option>Choose..</option>
                            <option value="FOB">FOB (Free On Board Port)</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="quotation-label">Value of the goods in USD</label>
                        <input type="number" title="Value of goods" name="value_of_goods"
                               placeholder="Value of goods (USD)" step="any" autocomplete="off" required=""
                               value="">
                    </div>
                    <div id="exw">
                        <div class="input-group">
                            <label class="quotation-label">Pick Up Address</label>
                            <input type="text" title="Pick Up Address" name="pickup_address"
                                   placeholder="Pick Up Address" step="any" autocomplete="off" value="" required>
                        </div>
                        <div class="input-group">
                            <label class="quotation-label">Final destination address</label>
                            <input type="text" title="Final destination address" name="final_destination_address"
                                   placeholder="Final destination address" step="any" autocomplete="off" value=""
                                   required>
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <label class="quotation-label">Description of goods</label>
                    <textarea name="description_of_goods" id="description_of_goods" cols="45" rows="5"></textarea>
                </div>
                <div class="form-grid">
                    <div class="input-group">
                        <label class="request-toggle">
                            <p class="label">Stackable Shipment</p>
                            <div class="toggle-wrap">
                                <input type="checkbox" name="isStockable" value="1" checked>
                                <div class="toggle-content">
                                    <span class="toggler" style="background: rgb(243, 156, 1);"></span>
                                    <div class="values">
                                        <p>No</p>
                                        <p>Yes</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="input-group">
                        <label class="request-toggle">
                            <p class="label">DGR Shipment</p>
                            <div class="toggle-wrap">
                                <input type="checkbox" name="isDGR" value="1">
                                <div class="toggle-content">
                                    <span class="toggler" style="background: rgb(243, 156, 1);"></span>
                                    <div class="values">
                                        <p>No</p>
                                        <p>Yes</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="input-group">
                        <div class="request-cascader">
                            <label class="request-toggle">
                                <p class="label">Requires customs clearance?</p>
                                <div class="toggle-wrap">
                                    <input type="checkbox" name="isClearanceReq" value="1">
                                    <div class="toggle-content">
                                        <span class="toggler" style="background: rgb(243, 156, 1);"></span>
                                        <div class="values">
                                            <p>No</p>
                                            <p>Yes</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="request-cascader">
                            <label class="request-toggle">
                                <p class="label">Insurance</p>
                                <div class="toggle-wrap">
                                    <input type="checkbox" name="insurance" value="1">
                                    <div class="toggle-content">
                                        <span class="toggler" style="background: rgb(243, 156, 1);"></span>
                                        <div class="values">
                                            <p>No</p>
                                            <p>Yes</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                @if($type === 'fcl')
                    <div class="input-group">
                        <h3 class="section-title">Add Container</h3>
                        <div id="container_fields">
                            <div class="container-field" style="margin: 20px 0 10px 0; gap: 10px" id="container-1">
                                <label for="" class="container-label">Container#1</label>
                                <div class="containers">
                                    <div class="form-row container-data">
                                        <div class="request-input medium">
                                            <p class="quotation-label">Size of container</p>
                                            <div class="request-select">
                                                <div class="select-wrap blue">
                                                    <select id="container_type" name="container_size[]" required="">
                                                        <option style="color: #908F8F">Choose..</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="request-input">
                                            <p class="quotation-label">Weight (Kg)</p>
                                            <div class="input-wrap">
                                                <input type="number" title="Weight" name="container_weight[]"
                                                       placeholder="0" step="any" autocomplete="off" required=""
                                                       value=""
                                                >
                                                <p class="label">KG</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-row" id="add_remove_containers" style="display: flex">
                                <button type="button" class="request-btn btn-sm manage-button-styles"
                                        id="add_container">
                                    <i class="fal fa-plus"></i>
                                </button>
                                <button type="button" class="request-btn btn-sm manage-button-styles"
                                        id="remove_container">
                                    <i class="fal fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($type === "lcl")
                    <div class="input-group">
                        <h3 class="section-title">Shipment Calculations</h3>
                        <div id="container_fields">
                            <div class="shipment-form">
                                <div class="type-form">
                                    <div class="request-radio-group">
                                        <label class="request-radio blue calculation-toggle">
                                            <input type="radio" name="calculate_by" value="shipment" checked>
                                            <span></span>
                                            <p>Calculate by total shipment</p>
                                        </label>
                                        <label class="request-radio blue calculation-toggle">
                                            <input type="radio" name="calculate_by" value="units"><span></span>
                                            <p>Calculate by units</p>
                                        </label>
                                    </div>

                                    <div id="shipment">
                                        <div class="shipment-dynamic-field form-row" id="shipment-1">
                                            <div class="request-input">
                                                <p class="name">Gross Weight</p>
                                                <div class="input-wrap">
                                                    <input
                                                        type="number"
                                                        name="shipment[0][gross_weight]"
                                                        min="1"
                                                        id="shipment_gross_weight_1"
                                                        placeholder="0"
                                                        step="any"
                                                    >
                                                    <p class="label">KG</p>
                                                </div>
                                            </div>
                                            <div class="request-input">
                                                <p class="name">Volumetric Weight</p>
                                                <div class="input-wrap">
                                                    <input
                                                        type="number"
                                                        name="shipment[0][volumetric_weight]"
                                                        min="1"
                                                        id="shipment_volumetric_weight_1"
                                                        placeholder="0"
                                                        step="any"
                                                    >
                                                    <p class="label">CBM</p>
                                                </div>
                                            </div>
                                            <div class="request-input">
                                                <p class="name">Quantity</p>
                                                <div class="input-wrap">
                                                    <input
                                                        type="number"
                                                        name="shipment[0][quantity]"
                                                        step="any"
                                                        id="shipment_quantity_1"
                                                        placeholder="0"
                                                        min="1"
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row" id="shipment_dynamic_buttons" style="display: flex">
                                            <button type="button" class="request-btn btn-sm manage-button-styles"
                                                    id="shipment-add-button">
                                                <i class="fal fa-plus"></i>
                                            </button>
                                            <button type="button" class="request-btn btn-sm manage-button-styles"
                                                    id="shipment-remove-button">
                                                <i class="fal fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div id="dynamic_fields" class="input-group">
                                        <div class="dynamic-field" style="margin: 20px 0 10px 0;" id="units-1">
                                            <label for="" class="container-label">Pallet#1</label>
                                            <div id="container_fields">
                                                <div class="dimensions form-row">
                                                    <div class="request-input">
                                                        <p class="name">Dimensions (cm)</p>
                                                        <div class="input-wrap">
                                                            <input
                                                                type="number"
                                                                title="Dimensions"
                                                                name="units[1][l]"
                                                                class="require dimension"
                                                                placeholder="L"
                                                                step="any"
                                                                id="length_1"
                                                                autocomplete="off"
                                                                value=""
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="request-input">
                                                        <p class="name"></p>
                                                        <div class="input-wrap">
                                                            <input
                                                                type="number"
                                                                title=" "
                                                                name="units[1][w]"
                                                                placeholder="W"
                                                                class="require dimension"
                                                                step="any"
                                                                id="width_1"
                                                                autocomplete="off"
                                                                value=""
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="request-input">
                                                        <p class="name"></p>
                                                        <div class="input-wrap">
                                                            <input
                                                                type="number"
                                                                title=" "
                                                                name="units[1][h]"
                                                                placeholder="H"
                                                                class="require dimension"
                                                                step="any"
                                                                id="height_1"
                                                                autocomplete="off"
                                                                value=""
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row" style="justify-content: space-between">
                                                <div class="request-input">
                                                    <p class="name">Volumetric Weight (cbm)</p>
                                                    <div class="input-wrap">
                                                        <input
                                                            type="number"
                                                            name="volumetric_weight_units[]"
                                                            placeholder="0"
                                                            id="volumetric_weight_units_1"
                                                            step="any"
                                                            autocomplete="off"
                                                            disabled
                                                        >
                                                    </div>
                                                </div>
                                                <div class="request-input">
                                                    <p class="name">Gross Weight (kg)</p>
                                                    <div class="input-wrap">
                                                        <input
                                                            type="number"
                                                            name="units[1][gross_weight]"
                                                            id="gross_weight_1"
                                                            placeholder="0"
                                                            step="any"
                                                            autocomplete="off"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row" id="dynamic_buttons" style="display: flex">
                                <button type="button" class="request-btn btn-sm manage-button-styles"
                                        id="add-button">
                                    <i class="fal fa-plus"></i>
                                </button>
                                <button type="button" class="request-btn btn-sm manage-button-styles"
                                        id="remove-button">
                                    <i class="fal fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="section-title">Other Info</h3>
                <div class="input-group">
                    <label class="quotation-label">Attach a file</label>
                    <input type="file" name="attachment">
                </div>
                <div class="input-group">
                    <label class="quotation-label">Remarks</label>
                    <textarea name="remarks" id="remarks" cols="45" rows="5"></textarea>
                </div>

                <button type="submit" class="next submit-button">Next</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Dynamic changes
        $(document).on('keyup', "input[name$='[l]'],input[name$='[w]'], input[name$='[h]']", function () {
            // Find the closest container (assumed to be marked with '.dynamic-field')
            const $container = $(this).closest('.dynamic-field');

            // Cache the input fields for length, width, and height
            const $lInput = $container.find("input[name^='units'][name$='[l]']");
            const $wInput = $container.find("input[name^='units'][name$='[w]']");
            const $hInput = $container.find("input[name^='units'][name$='[h]']");

            const l = parseFloat($lInput.val());
            const w = parseFloat($wInput.val());
            const h = parseFloat($hInput.val());

            if (!isNaN(l) && !isNaN(w) && !isNaN(h)) {
                const totalWeight = (l * w * h) / 1000000;
                $container.find("input[name^='volumetric_weight_units']").val(totalWeight.toFixed(2));
            }
        });

        let $exw = $('#exw'),
            $dynamicField = $('.dynamic-field'),
            $dynamicButtons = $('#dynamic_buttons'),
            $require = $(".require"),
            $shipment = $('#shipment'),
            $quantityInput = $("input[name=quantity]"),
            $totalWeightInput = $("input[name=total_weight]"),
            $pickupAddress = $("input[name=pickup_address]"),
            $finalDestinationInput = $("input[name=final_destination_address]");

        // Initial setup: Hide elements and set required property
        $exw.hide();
        $dynamicField.hide();
        $dynamicButtons.hide();
        $require.prop('required', false);

        // On calculation radio button changes
        $('input:radio').change(function () {
            let value = $(this).val();

            if (value === 'units') {
                $dynamicButtons.show();
                $dynamicField.show();
                $require.prop('required', true);

                $shipment.hide();
                $quantityInput.prop('required', false);
                $totalWeightInput.prop('required', false);
            } else {
                $dynamicField.hide();
                $dynamicButtons.hide();
                $shipment.show();
                $require.prop('required', false);
            }
        });

        // On Incoterms selection changes
        $('#incoterms').change(function () {
            let value = $(this).val();

            if (value === 'EXW') {
                $exw.show();
                $pickupAddress.prop('required', true);
                $finalDestinationInput.prop('required', true);
            } else {
                $exw.hide();
                $pickupAddress.prop('required', false);
                $finalDestinationInput.prop('required', false);
            }
        });
    });

</script>

<!-- Set containers type select -->
@if($type === 'fcl')
    <script>
        $(document).ready(function () {
            const select = document.getElementById('container_type');
            let dataArray = @json($containers);

            while (select.options.length > 1) {
                select.remove(1);
            }
            if (typeof dataArray === 'string') {
                dataArray = JSON.parse(dataArray);
            }

            dataArray.forEach(item => {
                const option = document.createElement('option');
                option.value = item.container_type;
                option.textContent = `${item.container_type}`;

                select.appendChild(option);
            });
        });
    </script>
@endif

<!-- Add dynamic input fields -->
<script>
    $(document).ready(function () {
        const $buttonAdd = $("#add-button");
        const $buttonRemove = $("#remove-button");
        const fieldSelector = ".dynamic-field";
        const maxFields = 50;
        let count = 1;

        function totalFields() {
            return $(fieldSelector).length;
        }

        function addNewField() {
            ++count;
            const $newField = $("#units-1").clone();

            $newField.attr("id", "units-" + count);
            $newField.children("label").text("Pallet# " + count);
            $newField.find("input").val("");
            $newField.find("#length_1").attr({
                id: "length_" + count,
                name: "units[" + count + "][l]",
            });
            $newField.find("#width_1").attr({
                id: "width_" + count,
                name: "units[" + count + "][w]",
            });
            $newField.find("#height_1").attr({
                id: "height_" + count,
                name: "units[" + count + "][h]",
            });
            $newField.find("#gross_weight_1").attr({
                id: "gross_weight_" + count,
                name: "units[" + count + "][gross_weight]",
            });
            $newField.find("#volumetric_weight_units_1").attr("id", "volumetric_weight_units_" + count);

            $(fieldSelector).last().after($newField);
        }

        function removeLastField() {
            if (totalFields() > 1) {
                $(fieldSelector).last().remove();
                --count;
            }
        }

        // Update the state (enabled/disabled and styles) of the add and remove buttons
        function updateButtons() {
            const total = totalFields();

            // Enable remove button if more than one field exists
            if (total > 1) {
                $buttonRemove.prop("disabled", false).addClass("shadow-sm");
            } else {
                $buttonRemove.prop("disabled", true).removeClass("shadow-sm");
            }

            // Enable add button if below the max field limit
            if (total < maxFields) {
                $buttonAdd.prop("disabled", false).addClass("shadow-sm");
            } else {
                $buttonAdd.prop("disabled", true).removeClass("shadow-sm");
            }
        }

        // Bind click events
        $buttonAdd.click(function () {
            addNewField();
            updateButtons();
        });

        $buttonRemove.click(function () {
            removeLastField();
            updateButtons();
        });

        // Initialize button states on page load
        updateButtons();
    });
</script>

<!-- Add Shipment dynamic input fields -->
<script>
    $(document).ready(function () {
        const $buttonAdd = $("#shipment-add-button");
        const $buttonRemove = $("#shipment-remove-button");
        const fieldSelector = ".shipment-dynamic-field";
        const maxFields = 50;
        let count = 1;

        function totalFields() {
            return $(fieldSelector).length;
        }

        function addNewField() {
            ++count;
            const $newField = $("#shipment-1").clone();

            $newField.attr("id", "shipment-" + count);
            $newField.find("#shipment_gross_weight_1").attr({
                id: "shipment_gross_weight_" + count,
                name: "shipment[" + count + "][gross_weight]",
            });
            $newField.find("#shipment_volumetric_weight_1").attr({
                id: "shipment_volumetric_weight_" + count,
                name: "shipment[" + count + "][volumetric_weight]",
            });
            $newField.find("#shipment_quantity_1").attr({
                id: "shipment_quantity_" + count,
                name: "shipment[" + count + "][quantity]",
            });

            $(fieldSelector).last().after($newField);
        }

        function removeLastField() {
            if (totalFields() > 1) {
                $(fieldSelector).last().remove();
                --count;
            }
        }

        // Update the state (enabled/disabled and styles) of the add and remove buttons
        function updateButtons() {
            const total = totalFields();

            // Enable remove button if more than one field exists
            if (total > 1) {
                $buttonRemove.prop("disabled", false).addClass("shadow-sm");
            } else {
                $buttonRemove.prop("disabled", true).removeClass("shadow-sm");
            }

            // Enable add button if below the max field limit
            if (total < maxFields) {
                $buttonAdd.prop("disabled", false).addClass("shadow-sm");
            } else {
                $buttonAdd.prop("disabled", true).removeClass("shadow-sm");
            }
        }

        // Bind click events
        $buttonAdd.click(function () {
            addNewField();
            updateButtons();
        });

        $buttonRemove.click(function () {
            removeLastField();
            updateButtons();
        });

        // Initialize button states on page load
        updateButtons();
    });
</script>

<!-- Add dynamic containers fields -->
<script>
    $(document).ready(function () {
        var buttonAdd = $("#add_container");
        var buttonRemove = $("#remove_container");
        var className = ".container-field";
        var count = 0;
        var field = "";
        var maxFields = 50;

        function totalFields() {
            return $(className).length;
        }

        function addNewField() {
            count = totalFields() + 1;
            field = $("#container-1").clone();
            field.attr("id", "container-" + count);
            field.children("label").text("Container# " + count);
            field.find("input").val("");
            $(className + ":last").after($(field));
        }

        function removeLastField() {
            if (totalFields() > 1) {
                $(className + ":last").remove();
            }
        }

        function enableButtonRemove() {
            if (totalFields() === 2) {
                buttonRemove.removeAttr("disabled");
                buttonRemove.addClass("shadow-sm");
            }
        }

        function disableButtonRemove() {
            if (totalFields() === 1) {
                buttonRemove.attr("disabled", "disabled");
                buttonRemove.removeClass("shadow-sm");
            }
        }

        function disableButtonAdd() {
            if (totalFields() === maxFields) {
                buttonAdd.attr("disabled", "disabled");
                buttonAdd.removeClass("shadow-sm");
            }
        }

        function enableButtonAdd() {
            if (totalFields() === (maxFields - 1)) {
                buttonAdd.removeAttr("disabled");
                buttonAdd.addClass("shadow-sm");
            }
        }

        buttonAdd.click(function () {
            addNewField();
            enableButtonRemove();
            disableButtonAdd();
        });

        buttonRemove.click(function () {
            removeLastField();
            disableButtonRemove();
            enableButtonAdd();
        });
    });

</script>

<style>
    .manage-button-styles {
        background: #F39C12;
        padding: 0 15px;
        height: 40px;
        margin: 0 0 20px 20px;
        font-size: 12px;
        border-radius: 10px;
    }
</style>
