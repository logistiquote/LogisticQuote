@extends('panels.layouts.master')
@section('content')
    @include('frontend.index.quote_info')
@endsection
@section('bottom_scripts')
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
@endsection
