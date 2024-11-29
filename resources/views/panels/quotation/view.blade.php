@extends('panels.layouts.master')
@section('content')

<div class="row">
    <div class="col-xl-10 col-md-12 mb-4 offset-md-1">
        <div class="card card shadow">
            <h5 class="card-header">
                Quotation

                @if($quotation->status == 'active')
                <span class="badge badge-success">{{ $quotation->status }}</span>
                @elseif($quotation->status == 'withdrawn')
                <span class="badge badge-danger">{{ $quotation->status }}</span>
                @elseif($quotation->status == 'completed')
                <span class="badge badge-primary">{{ $quotation->status }}</span>
                @endif
            </h5>
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <h5> <b> Origin </b> </h5>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $quotation->origin }}" readonly
                                name="origin_city" required>
                            @error('origin_city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5> <b> Destination </b> </h5>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $quotation->origin }}" readonly
                                name="origin_city" required>
                            @error('origin_city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationServer01">Ready to load date</label>
                            <?php $date = Carbon\Carbon::parse($quotation->ready_to_load_date); ?>
                            <input type="text" class="form-control" name="date" value="{{ $date->format('M d Y') }}"
                                readonly />

                        </div>
                    </div>

                    
                    <div class="form-row">
                        <div class="col-md-8 mb-3">

                            <label for="exampleFormControlTextarea1">Description of goods</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly
                                name="description_of_goods">{{ $quotation->description_of_goods }}</textarea>
                            @error('description_of_goods')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="incoterms">Incoterms</label>
                            <select class="custom-select mr-sm-2" id="incoterms" name="incoterms" disabled>
                                <option>Choose..</option>
                                <option value="EXW" <?php echo ($quotation->incoterms == 'EXW') ? 'selected="selected"' : ''; ?> >EXW (Ex Works Place)</option>
                                <option value="FOB" <?php echo ($quotation->incoterms == 'FOB') ? 'selected="selected"' : ''; ?> >FOB (Free On Board Port)</option>
                                <option value="CIP/CIF" <?php echo ($quotation->incoterms == 'CIP/CIF') ? 'selected="selected"' : ''; ?> >CIF/CIP (Cost Insurance & Freight / Carriage & Insurance Paid)</option>
                                <option value="DAP" <?php echo ($quotation->incoterms == 'DAP') ? 'selected="selected"' : ''; ?> >DAP (Delivered At Place)</option>
                            </select>
                        </div>
                    </div>

                    @if($quotation->incoterms == 'EXW')
                    <div id="exw">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationServer01">Pick Up Address</label>
                                <input type="text" class="form-control" name="pickup_address" value="{{ $quotation->pickup_address }}"  disabled />

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationServer01">Final destination address</label>
                                <input type="text" class="form-control" name="final_destination_address" value="{{ $quotation->pickup_address }}" value=""
                                    disabled />

                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-row">
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="transportation_type">Transportation Type</label>
                            <input type="text" class="form-control" value="{{ $quotation->transportation_type }}"
                                readonly>
                        </div>
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="transportation_type">Type of Shipment</label>
                            <input type="text" class="form-control" value="{{ $quotation->type }}" readonly>
                        </div>
                    </div>

                    <div class="row">                        
                        @if($quotation->type == 'fcl' && isset($quotation->containers))
                            @foreach($quotation->containers as $container)
                            <div class="col-md-4" style="margin: 0px 0px 10px 0px;" id="units-{{ $loop->iteration }}">
                                <label for="" style="font-weight: bold; margin: 35px 10px 0px 0px;">Container#{{ $loop->iteration }}</label>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="">Container size</label>
                                        
                                        {{ $container['size'] }}
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                                            name="container_size[]" disabled>
                                            <option value="20f-dc" <?php echo ($container['size']=='20f-dc') ? 'selected' : '' ?> >20' Dry Cargo</option>
                                            <option value="40f-dc" <?php echo ($container['size']=='40f-dc') ? 'selected' : '' ?> >40' Dry Cargo</option>
                                            <option value="40f-hdc" <?php echo ($container['size']=='40f-hdc') ? 'selected' : '' ?> >40' add-high Dry Cargo</option>
                                            <option value="45f-hdc" <?php echo ($container['size']=='45f-hdc') ? 'selected' : '' ?> >45' add-high Dry Cargo</option>
                                            <option value="20f-ot" <?php echo ($container['size']=='20f-ot') ? 'selected' : '' ?> >20' Open Top</option>
                                            <option value="40f-ot" <?php echo ($container['size']=='40f-ot') ? 'selected' : '' ?> >40' Open Top</option>
                                            <option value="20f-col" <?php echo ($container['size']=='20f-col') ? 'selected' : '' ?> >20' Collapsible</option>
                                            <option value="40f-col" <?php echo ($container['size']=='40f-col') ? 'selected' : '' ?> >40' Collapsible</option>
                                            <option value="20f-os" <?php echo ($container['size']=='20f-os') ? 'selected' : '' ?> >20' Open Side</option>
                                            <option value="20f-dv" <?php echo ($container['size']=='20f-dv') ? 'selected' : '' ?> >20' D.V for Side Floor</option>
                                            <option value="20f-ven" <?php echo ($container['size']=='20f-ven') ? 'selected' : '' ?> >20' Ventilated</option>
                                            <option value="40f-gar" <?php echo ($container['size']=='40f-gar') ? 'selected' : '' ?> >40' Garmentainer</option>
                                        </select>
                                        <label class="badge badge-info badge-2x" for="">Weight: {{ $container['weight'] }} Kg </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    <hr>
                    <h5 class="mt-4"> <b> Description of Goods </b> </h5>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="mr-sm-2">Value of Goods</label>
                            <input type="number" class="form-control @error('value_of_goods') is-invalid @enderror"
                                id="validationServer03" value="{{ $quotation->value_of_goods }}" readonly
                                name="value_of_goods" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <div class="col-auto my-1">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing"
                                        name="isStockable" value="Yes"
                                        <?php if($quotation->isStockable == 'Yes') echo 'checked="checked"'; ?>
                                        disabled>
                                    <label class="custom-control-label" for="customControlAutosizing">Is
                                        Stockable</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="col-auto my-1">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing2"
                                        name="isDGR" value="Yes"
                                        <?php if($quotation->isDGR == 'Yes') echo 'checked="checked"'; ?> disabled>
                                    <label class="custom-control-label" for="customControlAutosizing2">Is
                                        DGR</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mt-4"> <b> Shipment Calculations </b> </h5>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="calculate_by" value="shipment"
                                    class="custom-control-input"
                                    <?php if($quotation->calculate_by == 'shipment') echo 'checked="checked"'; ?>
                                    disabled>
                                <label class="custom-control-label" for="customRadioInline1">Calculate by total
                                    shipment</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="calculate_by" value="units"
                                    class="custom-control-input"
                                    <?php if($quotation->calculate_by == 'units') echo 'checked="checked"'; ?> disabled>
                                <label class="custom-control-label" for="customRadioInline2">Calculate by
                                    units</label>
                            </div>
                        </div>
                    </div>

                    @if($quotation->calculate_by == 'shipment')
                    <div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ $quotation->quantity }}" readonly name="quantity">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="number" class="form-control @error('total_weight') is-invalid @enderror"
                                    value="{{ $quotation->total_weight }}" readonly name="total_weight" required>
                            </div>
                        </div>
                    </div>
                    @elseif($quotation->calculate_by == 'units')
                        @foreach($quotation->pallets as $pallet)
                        <div class="form-row dynamic-field" style="margin: 20px 0px 10px 0px;" id="units-{{ $loop->iteration }}">
                            <label for="" style="font-weight: bold;">Pallet#{{ $loop->iteration }}</label>
                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="">length(cm)</label>
                                    <input type="number" class="form-control @error('l') is-invalid @enderror" disabled
                                        id="validationServer04" placeholder="length" name="l[]" value="{{ $pallet['length'] }}" required>
                                    @error('l')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="">width(cm)</label>
                                    <input type="number" class="form-control @error('w') is-invalid @enderror" disabled
                                        id="validationServer03" placeholder="width" name="w[]" value="{{ $pallet['width'] }}" required>
                                    @error('w')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="">height(cm)</label>
                                    <input type="number" class="form-control @error('h') is-invalid @enderror" disabled
                                        id="validationServer03" placeholder="height" name="h[]" value="{{ $pallet['height'] }}" required>
                                    @error('h')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3 ml-3">
                                    <label for="">Weight (kg)</label>
                                    <input type="number" class="form-control @error('total_weight_units') is-invalid @enderror"
                                        id="validationServer03" placeholder="Weight" value="{{ number_format((float)$pallet['volumetric_weight'], 2, '.', '') }}" disabled>
                                    @error('total_weight_units')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3 ml-3">
                                    <label for="">Gross Weight (kg)</label>
                                    <input type="number" class="form-control @error('total_weight_units') is-invalid @enderror"
                                        id="validationServer03" placeholder="Weight" value="{{ number_format((float)$pallet['gross_weight'], 2, '.', '') }}" disabled>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    @endif

                    <hr>
                    <h5 class="mt-4"> <b> Other Info </b> </h5>
                    <div class="form-row">
                        <div class="col-md-10 mb-3">

                            <label for="exampleFormControlTextarea1">Remarks</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remarks"
                                readonly>{{ $quotation->remarks }}</textarea>
                            @error('value_of_goods')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    @if(isset($attachment_url))
                    <div class="row">
                        <div class="col-md-12">
                            <a target="_blank" href="{{ $attachment_url }}" class="btn btn-success m-4">
                               <i class="fad fa-arrow-circle-down mr-2"></i>
                                View Attached File
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="form-row">
                        <div class="col-md-8 mb-3">
                            <div class="col-auto my-1">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input"
                                        <?php if($quotation->isClearanceReq == 'Yes') echo 'checked="checked"'; ?>
                                        readonly name="isClearanceReq" value="Yes">
                                    <label class="custom-control-label" for="customControlAutosizing3">Required
                                        Customs
                                        Clearance?</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                @if(Auth::user()->role == 'user')
                    @if($quotation->status == 'active')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
                            Withdraw Quotation
                        </button>
                    @elseif($quotation->status == 'withdrawn')
                        <p class="text-danger"> <b> You've withdrawn this quotation!</b> </p>
                    @elseif($quotation->status == 'completed')
                        <p class="text-success"> <b> This quotation has an accepeted proposal!</b> </p>
                    @elseif($quotation->status == 'done')
                        <p class="text-warning"> <b> This quotation's 24 hours of active status has been completed!</b> </p>
                    @endif
                @elseif(Auth::user()->role == 'vendor')
                    @if(is_offer_made(Auth::user()->id, $quotation->id))
                        <p class="text-primary"> <b> You've already sent a proposal!</b> </p> 
                    @elseif($quotation->status == 'active')
                        <a href="{{ route('proposal.make', $quotation->id) }}" class="btn btn-success">Make Offer</a>
                    @elseif($quotation->status == 'withdrawn')     
                        <p class="text-danger"> <b> The user has withdrawn this quotation!</b> </p>   
                    @elseif($quotation->status == 'completed')
                        <p class="text-success"> <b> This quotation has already been accepted!</b> </p>
                    @elseif($quotation->status == 'done')
                        <p class="text-warning"> <b> This quotation's 24 hours of active status has been completed!</b> </p>
                    @endif        
                @endif
            </div>
        </div>

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Withdraw <b class="text-warning"> Quotation#{{ $quotation->quotation_id }} </b> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('quotation.destroy', $quotation->id ) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="_method" value="DELETE">
                    Do you want to withdraw this quotation? 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
