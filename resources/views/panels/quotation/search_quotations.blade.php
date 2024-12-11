@extends('panels.layouts.master')
@section('content')


<div class="container">

    <!-- Search bar -->
    <h3> Search Quotations </h3>
    <hr>

    <form action="{{ route('quotations.search') }}" method="POST">
        @csrf
        <div class="searchPanel shadow p-3">
            <div class="row my-3 px-3">
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <input type="text" name="origin" class="form-control" placeholder="Origin">
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <input type="text" name="destination" class="form-control" placeholder="Destination">
                </div>


                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing"
                                name="isStockable" value="Yes">
                            <label class="custom-control-label" for="customControlAutosizing">Is
                                Stockable</label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing2"
                                name="isDGR" value="Yes">
                            <label class="custom-control-label" for="customControlAutosizing2">Is DGR</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row px-3">
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <label class="mr-sm-2" for="transportation_type">Transportation Type</label>
                    <select class="custom-select mr-sm-2" id="transportation_type" name="transportation_type">
                        <option selected="" value="">Choose...</option>
                        <option value="ocean">Ocean Freight</option>
                        <option value="air">Air Freight</option>
                    </select>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Type of Shipment</label>
                    <select class="custom-select mr-sm-2" id="type_of_shipment" name="type">
                        <option selected="" value="">Choose...</option>
                    </select>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 px-3">
                    <label for="">Customs clearance?</label>
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing3"
                            name="isClearanceReq" value="Yes">
                        <label class="custom-control-label" for="customControlAutosizing3">Required Customs
                            Clearance?</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12 offset-md-5 pt-3">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-search"></i> Search </button>
                </div>
            </div>
        </div>
    </form>
    <!-- Search bar -->


    <!-- Begin Page Content -->
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <!-- <h1 class="h3 mb-0 text-gray-800">Quotations</h1> -->
        </div>
        <!-- <p class="mb-4"> View status of your quotations.</p> -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quotations</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="quotations_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="20%">Route</th>
                                <th>Status</th>
                                <th>Proposals Received</th>
                                <th width="10%">Transportation</th>
                                <th width="13%">Ready to load</th>
                                <th>Worth</th>
                                <th width="10%">Gross Weight</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $quotation)
                            <tr>
                                <td> <b>{{ $quotation->quotation_id }} </b> </td>
                                <td>
                                    <span class="text-success">{{ $quotation->origin }}</span>
                                    to
                                    <span class="text-danger">{{ $quotation->destination }}</span>
                                </td>
                                <td>
                                    @if($quotation->status == 'active')
                                    <span class="badge badge-success">{{ $quotation->status }}</span>
                                    @elseif($quotation->status == 'withdrawn')
                                    <span class="badge badge-danger">{{ $quotation->status }}</span>
                                    @elseif($quotation->status == 'completed')
                                    <span class="badge badge-primary">{{ $quotation->status }}</span>
                                    @elseif($quotation->status == 'done')
                                    <span class="badge badge-warning">{{ $quotation->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-danger">{{ $quotation->proposals_received }}</span>
                                </td>
                                <td>{{ $quotation->transportation_type }} ({{ $quotation->type }})</td>
                                <td>
                                    <?php
                                $date = Carbon\Carbon::parse($quotation->ready_to_load_date);
                                echo $date->format('M d Y');
                            ?>
                                </td>
                                <td>{{ $quotation->value_of_goods }} $</td>
                                <td>{{ $quotation->total_weight }} KG</td>
                                <td>
                                    <a class=" btn btn-primary fa-2x"
                                        href="{{ route('quotation.show', $quotation->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- /.container-fluid -->

</div>

@endsection

@section('bottom_scripts')
<script>
    $(document).ready(function () {
        $('#quotations_table').DataTable();



        $("#transportation_type").change(function () {
            if ($(this).find(':selected').val() == 'ocean') {
                $('#type_of_shipment').empty();
                $("#type_of_shipment").append(new Option("LCL", "lcl"));
                $("#type_of_shipment").append(new Option("FCL", "fcl"));
            } else if ($(this).find(':selected').val() == 'air') {
                $('#type_of_shipment').empty();
                $("#type_of_shipment").append(new Option("AIR", "air"));
            }
        });


    });

</script>
@endsection
