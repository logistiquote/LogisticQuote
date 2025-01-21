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
                    <form role="form" action="{{ route('quotation.update', $quotation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <h5><b> Origin </b></h5>
                                <input type="text" class="form-control @error('origin') is-invalid @enderror"
                                       id="validationServer03" placeholder="City"
                                       value="{{ $quotation->route->full_origin_location }}" readonly
                                       name="origin" required>
                                @error('origin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5><b> Destination </b></h5>
                                <input type="text" class="form-control @error('destination') is-invalid @enderror"
                                       id="validationServer03" placeholder="City"
                                       value="{{ $quotation->route->full_destination_location }}" readonly
                                       name="destination" required>
                                @error('destination')
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

                        @if($quotation->incoterms == 'EXW')
                            <div id="exw">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationServer01">Pick Up Address</label>
                                        <input type="text" class="form-control" name="pickup_address"
                                               value="{{ $quotation->pickup_address }}" disabled/>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationServer01">Final destination address</label>
                                        <input type="text" class="form-control" name="final_destination_address"
                                               value="{{ $quotation->pickup_address }}" value=""
                                               disabled/>

                                    </div>
                                </div>
                            </div>
                        @endif

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

                        <hr>
                        <h5 class="mt-4"><b> Other Info </b></h5>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">

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
                                               <?php if ($quotation->is_clearance_req == 'Yes') echo 'checked="checked"'; ?>
                                               disabled name="is_clearance_req" value="Yes">
                                        <label class="custom-control-label" for="customControlAutosizing3">
                                            Required Customs Clearance?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->role === 'admin')
                            <button type="submit" class="btn btn-primary">Update</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
