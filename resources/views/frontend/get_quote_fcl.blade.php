@extends('frontend.layouts.app')
@section('content')
    <div class="main-content mt-5">
        <div class="container">
            <div class="form-container" style="text-align: left">
                <form class="form active contact-us-form" action="{{ route('frontend.quote_final_step') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <h3 class="section-title">Type of delivery</h3>
                    <div class="shipment-type">
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
                                <button type="button" class="request-btn btn-sm" id="add_container"
                                        style="background: #F39C12; padding: 0 15px; height: 40px; margin: 0 0 20px 0; font-size: 12px; border-radius: 10px;">
                                    <i class="fal fa-plus"></i>
                                </button>
                                <button type="button" class="request-btn btn-sm" id="remove_container"
                                        style="background: #F39C12; padding: 0 15px; height: 40px; margin: 0 0 20px 20px; font-size: 12px; border-radius: 10px;">
                                    <i class="fal fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

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
