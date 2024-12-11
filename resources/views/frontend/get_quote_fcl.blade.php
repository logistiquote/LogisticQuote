@extends('frontend.layouts.app')
@section('content')

<div class="app-wrapper container">
    <div class="shipping-form" style="display: inline-block;">
        <form action="{{ route('form_quote_step2') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2>Type of delivery</h2>
            <div class="shipment-type" style="margin: 20px 0px;">
                <div class="item">
                    <div class="icon"><i class="fad fa-boxes"></i></div>
                    <p>lcl</p>
                </div>
                <div class="item active">
                    <div class="icon"><i class="fad fa-container-storage"></i></div>
                    <p>fcl</p>
                </div>

                <input type="hidden" name="type" value="fcl">
            </div>

            <h2>Description Of Goods</h2>
            <div class="shipment-form">

                <div class="request-select large">
                    <p class="label">Incoterms</p>
                    <div class="select-wrap  blue">
                        <select name="incoterms" required="" id="incoterms">
                            <option>Choose..</option>
                            <option value="EXW">EXW (Ex Works Place)</option>
                            <option value="FOB">FOB (Free On Board Port)</option>
                            <option value="CIP/CIF">CIF/CIP (Cost Insurance & Freight / Carriage & Insurance Paid)
                            </option>
                            <option value="DAP">DAP (Delivered At Place)</option>
                        </select>
                    </div>
                </div>

                <div id="exw">
                    <div class="from-row">
                        <div class="request-input large">
                            <p class="name">Pick Up Address</p>
                            <div class="input-wrap  ">
                                <input type="text" title="Pick Up Address" name="pickup_address"
                                    placeholder="Pick Up Address" step="any" autocomplete="off" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="from-row">
                        <div class="request-input large">
                            <p class="name">Final destination address</p>
                            <div class="input-wrap  ">
                                <input type="text" title="Final destination address" name="final_destination_address"
                                    placeholder="Final destination address" step="any" autocomplete="off" value=""
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="from-row">
                    <div class="request-input large">
                        <p class="name">Value of the goods in USD</p>
                        <div class="input-wrap  ">
                            <input type="number" title="Value of goods" name="value_of_goods"
                                placeholder="Value of goods (USD)" step="any" autocomplete="off" required="" value="">
                        </div>
                    </div>
                </div>

                <div class="from-row">
                    <div class="request-input large">
                        <p class="name">Description of goods</p>
                        <div class="input-wrap">
                            <textarea name="description_of_goods" id="" cols="45" rows="3"
                                style="border-radius: 5px; border: 1px lite gray;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="from-row">

                    <h5> Add Container </h5>

                    <div id="container_fields">
                        <div class="form-row container-field" style="margin: 20px 0px 10px 0px;" id="container-1">
                            <label for="" style="margin: 30px 10px 0px 0px; font-weight: bold;">Container#1</label>
                            <div class="containers">

                                <div class="form-row">
                                    <div class="request-input small">
                                        <p class="name">Size of container</p>

                                        <div class="request-select medium">
                                            <div class="select-wrap  blue">
                                                <select name="container_size[]" required="">
                                                    <option>choose..</option>
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
                                                    <option value="20f-gar">40' Garmentainer</option>
                                                </select>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="request-input medium">
                                        <p class="name">Weight (Kg)</p>
                                        <div class="input-wrap  "><input type="number" title="Weight" name="container_weight[]"
                                                placeholder="0" step="any" autocomplete="off" required="" value="">
                                            <p class="label">KG</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-row" id="add_remove_containers">
                            <button type="button" class="request-btn btn-sm" id="add_container"
                                style="background: #F39C12; padding: 0px 15px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                                <i class="fal fa-plus"></i>
                            </button>
                            <button type="button" class="request-btn btn-sm" id="remove_container"
                                style="background: #F39C12; padding: 0px 15px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                                <i class="fal fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>


                <div class="form-row">

                    <div class="request-cascader">
                        <label class="request-toggle">
                            <p class="label">Stockable Shipment</p>
                            <div class="toggle-wrap">
                                <input type="checkbox" name="isStockable" value="yes">
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

                    <label class="request-toggle">
                        <p class="label">DGR Shipment</p>
                        <div class="toggle-wrap">
                            <input type="checkbox" name="isDGR" value="yes">
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

            <h2>Shipment Calculations</h2>
            <div class="shipment-form">
                <div class="type-form">

                    <div class="request-radio-group">
                        <label class="request-radio blue calculation-toggle">
                            <input type="radio" name="calculate_by" value="shipment" checked="">
                            <span></span>
                            <p>Calculate by total shipment</p>
                        </label>
                        <label class="request-radio blue calculation-toggle">
                            <input type="radio" name="calculate_by" value="units"><span></span>
                            <p>Calculate by units</p>
                        </label>
                    </div>

                    <div class="form-row" id="shipment">
                        <div class="request-input small">
                            <p class="name">Number of Pieces (Quantity)</p>
                            <div class="input-wrap  ">
                                <input type="number" title="Quantity" name="quantity" placeholder="0" step="any"
                                    autocomplete="off" value="">
                                <p class="label">PCS</p>
                            </div>
                        </div>
                        <div class="request-input small">
                            <p class="name">Gross Weight</p>
                            <div class="input-wrap  "><input type="number" title="Gross Weight" name="total_weight"
                                    placeholder="0" step="any" autocomplete="off" value="">
                                <p class="label">KG</p>
                            </div>
                        </div>
                    </div>

                    <div id="dynamic_fields">
                        <div class="form-row dynamic-field" style="margin: 20px 0px 10px 0px;" id="units-1">
                            <label for="" style="margin: 30px 10px 0px 0px; font-weight: bold;">Pallet#1</label>
                            <div class="dimensions">
                                <div class="request-input small">
                                    <p class="name">Dimensions</p>
                                    <div class="input-wrap">
                                        <input type="number" title="Dimensions" name="l[]" class="require dimension"
                                            placeholder="L" step="any" id="length_1" autocomplete="off" value="">
                                    </div>
                                </div>
                                <div class="request-input small">
                                    <p class="name"> </p>
                                    <div class="input-wrap">
                                        <input type="number" title=" " name="w[]" placeholder="W"
                                            class="require dimension" step="any" id="width_1" autocomplete="off"
                                            value="">
                                    </div>
                                </div>
                                <div class="request-input small">
                                    <p class="name"> </p>
                                    <div class="input-wrap">
                                        <input type="number" title=" " name="h[]" placeholder="H"
                                            class="require dimension" step="any" id="height_1" autocomplete="off"
                                            value="">
                                        <p class="label">CM</p>
                                    </div>
                                </div>
                            </div>
                            <div class="request-input small">
                                <p class="name">Volumetric Weight</p>
                                <div class="input-wrap">
                                    <input type="number" title="Gross Weight" name="total_weight_units[]"
                                        style="width: 120px;" id="total_weight_units_1" step="any" autocomplete="off"
                                        disabled="" value="">
                                    <p class="label">KG</p>
                                </div>
                            </div>
                            <div class="request-input medium">
                                <p class="name">Gross Weight (Kg)</p>
                                <div class="input-wrap  "><input type="number" title="Weight" name="gross_weight[]"
                                        placeholder="0" step="any" autocomplete="off" value="">
                                    <p class="label">KG</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row" id="dynamic_buttons">
                        <button type="button" class="request-btn btn-sm" id="add-button"
                            style="background: #F39C12; padding: 0px 15px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                            <!-- <span>Add New</span> -->
                            <i class="fal fa-plus"></i>
                        </button>
                        <button type="button" class="request-btn btn-sm" id="remove-button"
                            style="background: #F39C12; padding: 0px 15px; height: 40px; margin: 0px 0px 20px 20px; font-size: 12px; border-radius: 10px;">
                            <!-- <span>Add New</span> -->
                            <i class="fal fa-minus"></i>
                        </button>
                    </div>


                    <!-- <div class="shipment-total">
                        <p>Shipment total: <span id="pcs">0</span> PCS <span id="kg">0</span> kg</p>
                    </div> -->

                </div>
            </div>


            <h2>Other Info</h2>
            <div class="shipment-form">

                <div class="from-row">
                    <div class="request-input large">
                        <p class="name">Attach a file</p>
                        <div class="input-wrap  ">
                            <input type="file" style="border: 1px solid grey;" name="attachment">
                        </div>
                    </div>
                </div>

                <div class="from-row">
                    <div class="request-input large">
                        <p class="name">Remarks</p>
                        <div class="input-wrap  ">
                            <textarea name="remarks" id="" cols="45" rows="3"
                                style="border-radius: 5px; border: 1px lite gray;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="request-cascader">
                        <label class="request-toggle">
                            <p class="label">Reqires customs clearance?</p>
                            <div class="toggle-wrap">
                                <input type="checkbox" name="isClearanceReq" value="yes">
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
                    <div class="request-cascader">
                        <label class="request-toggle">
                            <p class="label">Goods Insurance</p>
                            <div class="toggle-wrap">
                                <input type="checkbox" name="insurance" value="yes">
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

            <div class="request-footer">
                <div class="btns">
                    <!-- <button type="submit" class="request-btn prev disabled"
                        style="background: rgb(243, 156, 1);">
                        <i class="fal fa-angle-left"></i>
                    </button> -->
                    <button type="submit" class="request-btn next " style="background: rgb(243, 156, 1);">
                        <span>Next</span>
                        <i class="fal fa-angle-right"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Dynamic changes
        $(document).on('keyup', "input[name^='l'], input[name^='w'], input[name^='h']", function () {
            $el = $(this);
            $unit_num = $el.parent().parent().parent().parent();
            if ($unit_num.find("input[name^='l']").val() && $unit_num.find("input[name^='w']").val() &&
                $unit_num.find("input[name^='h']").val()) {
                var l = $unit_num.find("input[name^='l']").val();
                var w = $unit_num.find("input[name^='w']").val();
                var h = $unit_num.find("input[name^='h']").val();
                var total_weight = (l * w * h) / 6000;
                $unit_num.find("input[name^='total_weight_units']").val(total_weight.toFixed(2));
            }
        });

        $('#exw').hide();
        $('.dynamic-field').hide();
        $('#dynamic_buttons').hide();
        $(".require").prop('required', false);

        // On calculation radio button clicks
        $('input:radio').change(function () {
            var el = $(this).val();
            if (el == 'units') {
                $('#dynamic_buttons').show();
                $('.dynamic-field').show();
                $(".require").prop('required', true);

                $('#shipment').hide();
                $("input[name=quantity]").prop('required', false);
                $("input[name=total_weight]").prop('required', false);
            } else {
                $('.dynamic-field').hide();
                $('#dynamic_buttons').hide();
                $('#shipment').show();

                $(".require").prop('required', false);
            }
        });

        // On Incoterms button clicks
        $('#incoterms').change(function () {
            var el = $(this).val();
            console.log(el);
            if (el == 'EXW') {
                $('#exw').show();
                $("input[name=pickup_address]").prop('required', true);
                $("input[name=final_destination_address]").prop('required',
                    true);
            } else {
                $('#exw').hide();
                $("input[name=pickup_address]").prop('required', false);
                $("input[name=final_destination_address]").prop('required',
                    false);
            }
        });

        // Live results on calculations
        $(
                "input[name=quantity_units], input[name=total_weight_units], input[name=total_weight], input[name=quantity], input[name=l], input[name=w], input[name=h]"
            )
            .keyup(function () {
                var el = $(this).attr("name");
                if (el == 'quantity') {
                    if ($(this).val() == "") {
                        $("#pcs").text('1');
                    } else {
                        $("#pcs").text($(this).val());
                    }
                } else if (el == 'total_weight') {
                    if ($(this).val() == "") {
                        $("#kg").text('1');
                    } else {
                        $("#kg").text($(this).val());
                    }
                }

                // For units
                // else {
                //     var quantity = $('input[name=quantity_units]').val() ? parseFloat($(
                //         'input[name=quantity_units]').val()) : 1;
                //     var l = $('input[name=l]').val() ? parseFloat($('input[name=l]').val()) : 1;
                //     var w = $('input[name=w]').val() ? parseFloat($('input[name=w]').val()) : 1;
                //     var h = $('input[name=h]').val() ? parseFloat($('input[name=h]').val()) : 1;

                //     var total_weight = (l * w * h) / 6000 * quantity;
                //     $('input[name=total_weight_units]').val(total_weight);
                //     $("#kg").text(total_weight);
                //     $("#pcs").text(quantity);
                // }
            });

    });

</script>

<!-- Add dynamic input fields -->
<script>
    $(document).ready(function () {
        var buttonAdd = $("#add-button");
        var buttonRemove = $("#remove-button");
        var className = ".dynamic-field";
        var count = 0;
        var field = "";
        var maxFields = 50;

        function totalFields() {
            return $(className).length;
        }

        function addNewField() {
            count = totalFields() + 1;
            field = $("#units-1").clone();
            field.attr("id", "units-" + count);
            field.children("label").text("Pallet# " + count);
            field.find("input").val("");
            field.find("#length_1").attr("id", "length_" + count);
            field.find("#width_1").attr("id", "width_" + count);
            field.find("#height_1").attr("id", "height_" + count);
            field.find("#total_weight_units_1").attr("id", "total_weight_units_" + count);
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
