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
