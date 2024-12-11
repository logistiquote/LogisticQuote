@extends('panels.layouts.master')
@section('content')

<style>
    i {
        margin-right: 10px;
    }

    /*------------------------*/
    input:focus,
    button:focus,
    .form-control:focus {
        outline: none;
        box-shadow: none;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #fff;
    }

    /*----------step-wizard------------*/
    .d-flex {
        display: flex;
    }

    .justify-content-center {
        justify-content: center;
    }

    .align-items-center {
        align-items: center;
    }

    /*---------signup-step-------------*/
    .bg-color {
        background-color: #333;
    }

    .signup-step-container {
        padding: 150px 0px;
        padding-bottom: 60px;
    }

    .wizard .nav-tabs {
        position: relative;
        margin-bottom: 0;
        border-bottom-color: transparent;
    }

    .wizard>div.wizard-inner {
        position: relative;
        margin-bottom: 50px;
        text-align: center;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 75%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 15px;
        z-index: 1;
    }

    .wizard .nav-tabs>li.active>a,
    .wizard .nav-tabs>li.active>a:hover,
    .wizard .nav-tabs>li.active>a:focus {
        color: #555555;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 30px;
        height: 30px;
        line-height: 30px;
        display: inline-block;
        border-radius: 50%;
        background: #fff;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 16px;
        color: #0e214b;
        font-weight: 500;
        border: 1px solid #ddd;
    }

    span.round-tab i {
        color: #555555;
    }

    .wizard li.active span.round-tab {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .wizard li.active span.round-tab i {
        color: #5bc0de;
    }

    .wizard .nav-tabs>li.active>a i {
        color: #007bff;
    }

    .wizard .nav-tabs>li {
        width: 25%;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: red;
        transition: 0.1s ease-in-out;
    }



    .wizard .nav-tabs>li a {
        width: 30px;
        height: 30px;
        margin: 20px auto;
        border-radius: 100%;
        padding: 0;
        background-color: transparent;
        position: relative;
        top: 0;
    }

    .wizard .nav-tabs>li a i {
        position: absolute;
        top: -15px;
        font-style: normal;
        font-weight: 400;
        white-space: nowrap;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        font-weight: 700;
        color: #000;
    }

    .wizard .nav-tabs>li a:hover {
        background: transparent;
    }

    .wizard .tab-pane {
        position: relative;
        padding-top: 20px;
    }


    .wizard h3 {
        margin-top: 0;
    }

    .prev-step,
    .next-step {
        font-size: 13px;
        padding: 8px 24px;
        border: none;
        border-radius: 4px;
        margin-top: 30px;
        background-color: #6c757d;
        color: #fff;
    }

    .next-step {
        color: #fff;
        background-color: #007bff;
    }

    .step-head {
        font-size: 20px;
        text-align: center;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .term-check {
        font-size: 14px;
        font-weight: 400;
    }

    .custom-file {
        position: relative;
        display: inline-block;
        width: 100%;
        height: 40px;
        margin-bottom: 0;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 40px;
        margin: 0;
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: 40px;
        padding: .375rem .75rem;
        font-weight: 400;
        line-height: 2;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: 38px;
        padding: .375rem .75rem;
        line-height: 2;
        color: #495057;
        content: "Browse";
        background-color: #e9ecef;
        border-left: inherit;
        border-radius: 0 .25rem .25rem 0;
    }

    .footer-link {
        margin-top: 30px;
    }

    .all-info-container {}

    .list-content {
        margin-bottom: 10px;
    }

    .list-content a {
        padding: 10px 15px;
        width: 100%;
        display: inline-block;
        background-color: #f5f5f5;
        position: relative;
        color: #565656;
        font-weight: 400;
        border-radius: 4px;
    }

    .list-content a[aria-expanded="true"] i {
        transform: rotate(180deg);
    }

    .list-content a i {
        text-align: right;
        position: absolute;
        top: 15px;
        right: 10px;
        transition: 0.5s;
    }

    .form-control[disabled],
    .form-control[readonly],
    fieldset[disabled] .form-control {
        background-color: #fdfdfd;
    }

    .list-box {
        padding: 10px;
    }

    .signup-logo-header .logo_area {
        width: 200px;
    }

    .signup-logo-header .nav>li {
        padding: 0;
    }

    .signup-logo-header .header-flex {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .list-inline li {
        display: inline-block;
    }

    .pull-right {
        float: right;
    }

    /*-----------custom-checkbox-----------*/
    /*----------Custom-Checkbox---------*/
    input[type="checkbox"] {
        position: relative;
        display: inline-block;
        margin-right: 5px;
    }

    input[type="checkbox"]::before,
    input[type="checkbox"]::after {
        position: absolute;
        content: "";
        display: inline-block;
    }

    input[type="checkbox"]::before {
        height: 16px;
        width: 16px;
        border: 1px solid #999;
        left: 0px;
        top: 0px;
        background-color: #fff;
        border-radius: 2px;
    }

    input[type="checkbox"]::after {
        height: 5px;
        width: 9px;
        left: 4px;
        top: 4px;
    }

    input[type="checkbox"]:checked::after {
        content: "";
        border-left: 1px solid #fff;
        border-bottom: 1px solid #fff;
        transform: rotate(-45deg);
    }

    input[type="checkbox"]:checked::before {
        background-color: #18ba60;
        border-color: #18ba60;
    }






    @media (max-width: 767px) {
        .sign-content h3 {
            font-size: 40px;
        }

        .wizard .nav-tabs>li a i {
            display: none;
        }

        .signup-logo-header .navbar-toggle {
            margin: 0;
            margin-top: 8px;
        }

        .signup-logo-header .logo_area {
            margin-top: 0;
        }

        .signup-logo-header .header-flex {
            display: block;
        }
    }

</style>

<section class="">
    <div class="container">

        <div class="show-errors mb-5">
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error#{{$loop->iteration}}: </strong> {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endforeach
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"
                                    aria-expanded="true"><span class="round-tab">1 </span> <i>Basic</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                    aria-expanded="false"><span class="round-tab">2</span> <i>Description</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span
                                        class="round-tab">3</span> <i>Calculation</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span
                                        class="round-tab">4</span> <i>Other</i></a>
                            </li>
                        </ul>
                    </div>

                    <form role="form" action="{{ route('quotation.update', $quotation->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{ $quotation->id }}">

                        <div class="tab-content" id="main_form">

                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h4 class="text-center">Basic Info</h4>
                                <hr>
                                <div class="row">

                                    <div class="col-md-12">
                                        <label>Origin *</label>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text"
                                            class="form-control @error('origin') is-invalid @enderror"
                                            id="validationServer03" placeholder="City"
                                            value="{{ $quotation->origin }}" name="origin">
                                        @error('origin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 my-3">
                                        <label>Destination *</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text"
                                            class="form-control @error('destination') is-invalid @enderror"
                                            id="validationServer03" placeholder="City" name="destination"
                                            value="{{ $quotation->destination }}">
                                        @error('destination')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6"></div>

                                    <div class="col-md-4 my-3">
                                        <label for="validationServer01">Ready to load date</label>
                                        <input type="text" class="form-control @error('ready_to_load_date') is-invalid @enderror" name="ready_to_load_date"
                                            value="{{ $quotation->ready_to_load_date }}" />
                                            @error('ready_to_load_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                    </div>

                                    <div class="col-md-9 mb-3">
                                        <label for="exampleFormControlTextarea1">Description of goods</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                            name="description_of_goods">{{ $quotation->description_of_goods }}</textarea>
                                        @error('description_of_goods')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                                <ul class="list-inline pull-right">
                                    <li>
                                        <button type="button" class="default-btn next-step">Continue to next
                                            step</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h4 class="text-center">Description of Goods</h4>
                                <hr>
                                <div class="row">

                                    <div class="col-md-6">
                                        <label class="mr-sm-2" for="incoterms">Incoterms</label>
                                        <select class="custom-select mr-sm-2 @error('incoterms') is-invalid @enderror" id="incoterms" name="incoterms"
                                            value="{{ $quotation->incoterms }}">
                                            <option value="">Choose..</option>
                                            <option value="EXW" <?php echo ($quotation->incoterms == 'EXW') ? 'selected' : ''; ?>>EXW (Ex Works Place)</option>
                                            <option value="FOB" <?php echo ($quotation->incoterms == 'FOB') ? 'selected' : ''; ?>>FOB (Free On Board Port)</option>
                                            <option value="CIP/CIF" <?php echo ($quotation->incoterms == 'CIP/CIF') ? 'selected' : ''; ?>>CIF/CIP (Cost Insurance & Freight / Carriage &
                                                Insurance Paid)
                                            </option>
                                            <option value="DAP" <?php echo ($quotation->incoterms == 'DAP') ? 'selected' : ''; ?>>DAP (Delivered At Place)</option>
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
                                                value="{{ $quotation->pickup_address }}" />
                                        </div>

                                        <div class="col-md-6">
                                            <label for="validationServer01">Final destination address</label>
                                            <input type="text" class="form-control" name="final_destination_address"
                                                value="{{ $quotation->destination_address }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 my-3">
                                        <label for="">Value of Goods</label>
                                        <input type="number"
                                            class="form-control @error('value_of_goods') is-invalid @enderror"
                                            id="validationServer03" placeholder="Value of Goods (USD)"
                                            name="value_of_goods" value="{{ $quotation->value_of_goods }}">
                                        @error('value_of_goods')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-auto my-1">
                                        <label class="mr-sm-2" for="transportation_type">Transportation Type</label>
                                        <select class="custom-select mr-sm-2 @error('transportation_type') is-invalid @enderror" id="transportation_type"
                                            name="transportation_type" disabled>
                                            <option value="" selected>Choose...</option>
                                            <option value="ocean" <?php echo ($quotation->transportation_type == 'ocean') ? 'selected' : ''; ?> >Ocean Freight</option>
                                            <option value="air" <?php echo ($quotation->transportation_type == 'air') ? 'selected' : ''; ?>>Air Freight</option>
                                        </select>
                                        @error('transportation_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-auto my-1">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Type of Shipment</label>
                                        <select class="custom-select mr-sm-2 @error('type') is-invalid @enderror" id="type_of_shipment" name="type" disabled>
                                            <option value="" selected>Choose...</option>
                                        </select>
                                        @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                @if($quotation->type == 'fcl')
                                <!-- Dynamic Containers -->
                                <div id="for_flc2">
                                    <div class="row" id="dynamic_containers">

                                        <div class="col-md-12">
                                            <label class="mt-3">Containers Specification</label>
                                        </div>
                                        @if($quotation->type == 'fcl')
                                            @foreach($quotation->containers as $container)
                                            <div class="dynamic-container row" style="margin: 20px 0px 5px 0px;"
                                                id="container-{{ $loop->iteration }}">
                                                <label for="" style="font-weight: bold;">Container#{{ $loop->iteration }}</label>
                                                <div class="col-md-5 mb-3">
                                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                                                        name="container_size[]">
                                                        <option value="">Container size</option>
                                                        <option value="20f-dc <?php echo ($container['size'] == '20f-dc') ? 'selected' : ''; ?> ">20' Dry Cargo</option>
                                                        <option value="40f-dc <?php echo ($container['size'] == '40f-dc') ? 'selected' : ''; ?> ">40' Dry Cargo</option>
                                                        <option value="40f-hdc <?php echo ($container['size'] == '40f-hdc') ? 'selected' : ''; ?> ">40' add-high Dry Cargo</option>
                                                        <option value="45f-hdc <?php echo ($container['size'] == '45f-hdc') ? 'selected' : ''; ?> ">45' add-high Dry Cargo</option>
                                                        <option value="20f-ot <?php echo ($container['size'] == '20f-ot') ? 'selected' : ''; ?> ">20' Open Top</option>
                                                        <option value="40f-ot <?php echo ($container['size'] == '40f-ot') ? 'selected' : ''; ?> ">40' Open Top</option>
                                                        <option value="20f-col <?php echo ($container['size'] == '20f-col') ? 'selected' : ''; ?> ">20' Collapsible</option>
                                                        <option value="40f-col <?php echo ($container['size'] == '40f-col') ? 'selected' : ''; ?> ">40' Collapsible</option>
                                                        <option value="20f-os <?php echo ($container['size'] == '20f-os') ? 'selected' : ''; ?> ">20' Open Side</option>
                                                        <option value="20f-dv <?php echo ($container['size'] == '20f-dv') ? 'selected' : ''; ?> ">20' D.V for Side Floor</option>
                                                        <option value="20f-ven <?php echo ($container['size'] == '20f-ven') ? 'selected' : ''; ?> ">20' Ventilated</option>
                                                        <option value="40f-gar <?php echo ($container['size'] == '40f-gar') ? 'selected' : ''; ?> ">40' Garmentainer</option>
                                                    </select>
                                                    @error('container_size')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <input type="number"
                                                        class="form-control @error('container_weight') is-invalid @enderror"
                                                        id="validationServer03" placeholder="Weight (kg)"
                                                        name="container_weight[]" value="{{ $container['weight'] }}">
                                                    @error('container_weight[]')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
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
                                @endif

                                <div class="form-row my-3">
                                    <div class="col-md-3 mb-3">
                                        <div class="col-auto my-1">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input" <?php if($quotation->isStockable == 'Yes') echo 'checked="checked"'; ?>
                                                    id="customControlAutosizing" name="isStockable" value="Yes">
                                                <label class="custom-control-label" for="customControlAutosizing">Is
                                                    Stockable</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="col-auto my-1">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input" <?php if($quotation->isDGR == 'Yes') echo 'checked="checked"'; ?>
                                                    id="customControlAutosizing2" name="isDGR" value="Yes">
                                                <label class="custom-control-label" for="customControlAutosizing2">Is
                                                    DGR</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h4 class="text-center">Shipment Calculations</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <div id="if_not_air">
                                                <input type="radio" id="by_total_shipment" name="calculate_by" <?php if($quotation->calculate_by == 'shipment') echo 'checked="checked"'; ?>
                                                    value="shipment" class="custom-control-input" disabled>
                                                <label class="custom-control-label" for="by_total_shipment">Calculate
                                                    by total
                                                    shipment</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="by_units" name="calculate_by" <?php if($quotation->calculate_by == 'units') echo 'checked="checked"'; ?>
                                                value="units" class="custom-control-input" disabled>
                                            <label class="custom-control-label" for="by_units">Calculate
                                                by units</label>
                                        </div>
                                    </div>
                                </div>

                                @if($quotation->calculate_by == 'shipment')
                                <div id="shipment2">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="">Quantity</label>
                                            <input type="number"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                id="validationServer03" placeholder="Quantity" name="quantity"
                                                value="{{ $quotation->quantity }}">
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
                                                value="{{ $quotation->total_weight }}">
                                            @error('total_weight')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @elseif($quotation->calculate_by == 'units')
                                <div class="row">
                                    <div id="dynamic_fields2">
                                        @foreach($quotation->pallets as $pallet)
                                        <div class="form-row dynamic-field2" style="margin: 20px 0px 10px 0px;"
                                            id="units-{{ $loop->iteration }}">
                                            <label for="" style="font-weight: bold;">Pallet#{{ $loop->iteration }}</label>
                                            <!-- <label for="">Dimensions (cm)</label> -->
                                            <div class="form-row">
                                                <div class="col-md-2 mb-3">
                                                    <label for="">Length (cm)</label>
                                                    <input type="number"
                                                        class="form-control @error('l') is-invalid @enderror" value="{{ $pallet['length'] }}"
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
                                                        class="form-control @error('w') is-invalid @enderror" value="{{ $pallet['width'] }}"
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
                                                        class="form-control @error('h') is-invalid @enderror" value="{{ $pallet['height'] }}"
                                                        id="validationServer03" placeholder="height" name="h[]">
                                                    @error('h')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 mb-3 ml-3">
                                                    <label for="">Gross Weight (kg)</label>
                                                    <input type="number" value="{{ $pallet['gross_weight'] }}"
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
                                                    <label for="">Vol Weight (KG)</label>
                                                    <input type="number"
                                                        class="form-control @error('total_weight_units') is-invalid @enderror" value="{{ $pallet['volumetric_weight'] }}"
                                                        id="validationServer03" placeholder="Weight"
                                                        name="total_weight_units[]" disabled>
                                                    @error('total_weight_units')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        @endforeach
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
                                @endif

                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-pane" role="tabpanel" id="step4">
                                <h4 class="text-center">Other Info</h4>
                                <hr>
                                <div class="all-info-container">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">

                                            <label for="exampleFormControlTextarea1">Remarks</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                                name="remarks">{{ $quotation->remarks }}</textarea>
                                            @error('remarks')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="custom-control custom-checkbox"> 
                                                <input type="checkbox" class="custom-control-input" <?php if($quotation->isClearanceReq == 'Yes') echo 'checked="checked"'; ?>
                                                    id="customControlAutosizing3" name="isClearanceReq" value="Yes">
                                                <label class="custom-control-label" for="customControlAutosizing3">
                                                    Customs Clearance?</label>
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
                                    <li><button type="submit" class="default-btn next-step">Request Quotation</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="clearfix"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('bottom_scripts')
<script>
    $(document).ready(function () {

        var trans_type = {!! json_encode($quotation->transportation_type) !!};
        var calculated_by = {!! json_encode($quotation->calculate_by) !!};
        var type = {!! json_encode($quotation->type) !!};
        var incoterms = {!! json_encode($quotation->incoterms) !!};
        if(incoterms == 'EXW')
        {
            $('#exw').show();
        }
        if(calculated_by == 'units')
        {

            $("#by_units").prop('checked', true);
        }
        else
        {
            $("#by_total_shipment").prop('checked', true);
        }

        if(type == 'fcl')
        {
            $('#for_flc').show();
            $("#type_of_shipment option[value='fcl']").prop('selected', true);
        }
        if(trans_type == 'ocean')
        {
            $('#type_of_shipment').empty();
            $("#type_of_shipment").append(new Option("LCL", "lcl"));
            $("#type_of_shipment").append(new Option("FCL", "fcl"));
            if(type == 'fcl')
            {
                $("#type_of_shipment option[value='fcl']").prop('selected', true);
            }
            else
            {}
        }
        else
        {
            $('#type_of_shipment').empty();
            $("#type_of_shipment").append(new Option("AIR", "air"));
        }

        // Dynamic changes
        $(document).on('keyup', "input[name^='l'], input[name^='w'], input[name^='h']", function () {
            $el = $(this);
            $unit_num = $el.parent().parent().parent();
            console.log($unit_num);
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
        

    
        $("#transportation_type").change(function () {
            if ($(this).find(':selected').val() == 'ocean') {
                $('#if_not_air').show();
                $('#type_of_shipment').empty();
                $("#type_of_shipment").append(new Option("LCL", "lcl"));
                $("#type_of_shipment").append(new Option("FCL", "fcl"));
            } else if ($(this).find(':selected').val() == 'air') {
                $('#type_of_shipment').empty();
                $('#if_not_air').hide();
                $("#type_of_shipment").append(new Option("AIR", "air"));
                $('#for_flc').hide();
            }
        }); 

        // FCL options
        $("#type_of_shipment").change(function () {
            if ($(this).find(':selected').val() == 'fcl') {
                $('#for_flc').show();
            } else {
                $('#for_flc').hide();
            }
        });

        // On calculation radio button clicks
        $('input:radio').change(function () {
            var el = $(this).val();
            if (el == 'units') {
                $('#dynamic_buttons').show();
                $('.dynamic-field').show();
                $(".require").prop('', true);

                $('#shipment').hide();
                $("input[name=quantity]").prop('', false);
                $("input[name=total_weight]").prop('', false);
            } else {
                $('.dynamic-field').hide();
                $('#dynamic_buttons').hide();
                $('#shipment').show();

                $(".require").prop('', false);
            }
        });

        // Live results on calculations
        $("input[name=quantity_units], input[name=total_weight_units], input[name=l], input[name=w], input[name=h]")
            .keyup(function () {
                console.log('123');
                var quantity = $('input[name=quantity_units]').val() ? parseFloat($(
                    'input[name=quantity_units]').val()) : 1;
                var l = $('input[name=l]').val() ? parseFloat($('input[name=l]').val()) : 1;
                var w = $('input[name=w]').val() ? parseFloat($('input[name=w]').val()) : 1;
                var h = $('input[name=h]').val() ? parseFloat($('input[name=h]').val()) : 1;

                var total_weight = (l * w * h) / 6000 * quantity;
                $('input[name=total_weight_units]').val(total_weight);
                // $("#kg").text(total_weight);
                // $("#pcs").text(quantity);
            });


        // On Incoterms button clicks
        $('#incoterms').change(function () {
            var el = $(this).val();
            console.log(el);
            if (el == 'EXW') {
                $('#exw').show();
                $("input[name=pickup_address]").prop('', true);
                $("input[name=final_destination_address]").prop('',
                    true);
            } else {
                $('#exw').hide();
                $("input[name=pickup_address]").prop('', false);
                $("input[name=final_destination_address]").prop('',
                    false);
            }
        });

    });

    $(function () {
        $('input[name="ready_to_load_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            maxYear: 2050,
            locale: {
                format: 'D-M-YYYY'
            }
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

<!-- Add dynamic containers -->
<script>
    $(document).ready(function () {
        var buttonAdd = $("#add_container");
        var buttonRemove = $("#remove_container");
        var className = ".dynamic-container";
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

<script>
    $(document).ready(function () {
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

            var target = $(e.target);

            if (target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function (e) {

            var active = $('.wizard .nav-tabs li.active');
            active.next().removeClass('disabled');
            nextTab(active);

        });
        $(".prev-step").click(function (e) {

            var active = $('.wizard .nav-tabs li.active');
            prevTab(active);

        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }

    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }


    $('.nav-tabs').on('click', 'li', function () {
        $('.nav-tabs li.active').removeClass('active');
        $(this).addClass('active');
    });

</script>

@endsection
