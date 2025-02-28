<div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <h5><b> Origin </b></h5>
            <input
                type="text"
                class="form-control"
                value="{{ $quotation->shipment?->full_origin_location }}"
                disabled>
        </div>
        <div class="col-md-6 mb-3">
            <h5><b> Destination </b></h5>
            <input
                type="text"
                class="form-control"
                value="{{ $quotation->shipment?->full_destination_location}}"
                disabled
            >
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="validationServer01">Ready to load date</label>
            <?php $date = Carbon\Carbon::parse($quotation->ready_to_load_date); ?>
            <input type="text" class="form-control" name="ready_to_load_date" value="{{ $date->format('M d Y') }}"
                   readonly/>

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
                <option
                    value="FOB" <?php echo ($quotation->incoterms == 'FOB') ? 'selected="selected"' : ''; ?> >
                    FOB (Free On Board Port)
                </option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="col-auto my-1">
            <label class="mr-sm-2" for="transportation_type">Transportation Type</label>
            <input type="text" class="form-control" name="transportation_type" value="{{ $quotation->transportation_type }}"
                   readonly>
        </div>
        <div class="col-auto my-1">
            <label class="mr-sm-2" for="type">Type of Shipment</label>
            <input type="text" class="form-control" name="type" value="{{ $quotation->type }}" readonly>
        </div>
    </div>

    <div class="row">
        @if($quotation->type == 'fcl' && isset($quotation->containers))
            @foreach($quotation->containers as $container)
                <div class="col-md-4" style="margin: 0 0 10px 0;" id="units-{{ $loop->iteration }}">
                    <label for="" style="font-weight: bold; margin: 35px 10px 0 0;">
                        Container#{{ $loop->iteration }}
                    </label>
                    <input type="hidden" name="container_size[{{$container->id}}]" value="{{ $container->routeContainer->container_type }}">
                    <input type="hidden" name="container_price[{{$container->id}}]" value="{{ $container->price_per_container }}">
                    <input type="hidden" name="container_weight[{{$container->id}}]" value="{{ $container->weight }}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="">Container size</label>
                            <input
                                class="custom-select mr-sm-2"
                                value=" {{ $container->routeContainer->container_type }}"
                                disabled
                            >
                            <input
                                class="form-control mt-2"
                                name="container_price[{{$container->id}}]"
                                value=" {{ $container->price_per_container }}"
                                @if($container->price_per_container != 0 || Auth::user()->role !== 'admin') disabled @endif
                            >
                            <label class="badge badge-info badge-2x" for="">
                                Weight: {{ $container->weight }} Kg
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <hr>
    <h5 class="mt-4"><b> Description of Goods </b></h5>
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
            <label class="mr-sm-2">Insurance price ($)</label>
            <input type="number" class="form-control @error('insurance_price') is-invalid @enderror"
                   id="validationServer03" value="{{ $quotation->insurance_price }}" readonly
                   name="insurance_price" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing"
                           name="is_stockable" value="Yes"
                           <?php if ($quotation->is_stockable == '1') echo 'checked="checked"'; ?>
                           disabled>
                    <label class="custom-control-label" for="customControlAutosizing">Is
                        Stackable</label>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input"
                           id="customControlAutosizing2"
                           name="is_dgr" value="Yes"
                           <?php if ($quotation->is_dgr == 'Yes') echo 'checked="checked"'; ?> disabled>
                    <label class="custom-control-label" for="customControlAutosizing2">Is
                        DGR</label>
                </div>
            </div>
        </div>
    </div>
</div>
