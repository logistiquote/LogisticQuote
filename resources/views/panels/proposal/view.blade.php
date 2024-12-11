@extends('panels.layouts.master')
@section('content')

<div class="row">
    <div class="col-xl-8 col-md-8 mb-4 offset-md-2">
        <div class="card card shadow">
            <h5 class="card-header">
                Proposal for <b class="text-warning">quotation#{{ $proposal->quotation->quotation_id }} </b>
                @if($proposal->status == 'active')
                <span class="badge badge-success">{{ $proposal->status }}</span>
                @elseif($proposal->status == 'withdrawn')
                <span class="badge badge-danger">{{ $proposal->status }}</span>
                @elseif($proposal->status == 'completed')
                <span class="badge badge-primary">{{ $proposal->status }}</span>
                @endif
            </h5>
            <div class="card-body">
                <form>
                    <h5> <b> Proposal Specifications </b> </h5>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for=""> Actual Local Charges (USD) </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $proposal->local_charges }}$"
                                readonly name="local_charges" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for=""> Freight Charges (USD) </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $proposal->freight_charges }}$"
                                readonly name="freight_charges" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for=""> Destination Local Charges (USD) </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City"
                                value="{{ $proposal->destination_local_charges }}$" readonly
                                name="destination_local_charges" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for=""> Customs Clearance Charges (USD) </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City"
                                value="{{ $proposal->customs_clearance_charges }}$" readonly
                                name="customs_clearance_charges" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for=""> Subtotal (USD) </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $proposal->total }}$" readonly
                                name="total" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationServer01">The proposal is valid till</label>
                            <?php $date = Carbon\Carbon::parse($proposal->valid_till); ?>
                            <input type="text" class="form-control" name="date" value="{{ $date->format('M d Y') }}"
                                readonly />

                        </div>
                    </div>

                    <h5> <b> Vendor Details </b> </h5>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for=""> Vendor Name: </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $proposal->vendor->name }}"
                                readonly name="local_charges" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for=""> Vendor Phone: </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $proposal->vendor->phone }}"
                                readonly name="freight_charges" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for=""> Vendor Email: </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City" value="{{ $proposal->vendor->email }}"
                                readonly name="local_charges" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for=""> Vendor Additional Email: </label>
                            <input type="text" class="form-control @error('origin_city') is-invalid @enderror"
                                id="validationServer03" placeholder="City"
                                value="{{ $proposal->vendor->additional_email }}" readonly name="freight_charges"
                                required>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mt-4"> <b> Other Info </b> </h5>
                    <div class="form-row">
                        <div class="col-md-10 mb-3">

                            <label for="exampleFormControlTextarea1">Remarks</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remarks"
                                readonly>{{ $proposal->remarks }}</textarea>
                        </div>
                    </div>

                </form>
                @if(Auth::user()->role == 'user')
                    @if(is_proposal_expired($proposal->id) )
                        <p class="text-danger"> <b> The proposal has expired on {{ carbon_format($proposal->valid_till, 'd M Y') }} !</b> </p>
                    @elseif($proposal->status == 'active')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                            Accept Proposal
                        </button>
                    @elseif($proposal->status == 'withdrawn')
                        <p class="text-danger"> <b> The proposal is no longer available!</b> </p>
                    @elseif($proposal->status == 'completed')
                        <p class="text-success"> <b> You've already accepted this proposal!</b> </p>
                    @endif

                @elseif(Auth::user()->role == 'vendor')
                        <a class="btn btn-primary mx-3" href="{{ route('proposal.edit', $proposal->id) }}">Change Terms</a>
                    @if($proposal->status == 'active')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#withdrawproposal">
                            Withdraw Proposal
                        </button>
                    @elseif($proposal->status == 'withdrawn')
                        <p class="text-danger"> <b> You've withdrawn this proposal!</b> </p>
                    @elseif($proposal->status == 'completed')
                        <p class="text-success"> <b> The proposal has been accepted!</b> </p>
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
                <h5 class="modal-title" id="exampleModalLongTitle">Proposal for <b class="text-warning">quotation#{{ $proposal->quotation->quotation_id }} </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to accept this proposal?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('proposal.accept', $proposal->id) }}" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="withdrawproposal" tabindex="-1" role="dialog" aria-labelledby="withdrawproposalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Proposal for <b class="text-warning">quotation#{{ $proposal->quotation->quotation_id }} </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to withdraw this proposal?
            </div>
            <div class="modal-footer">
                <form action="{{ route('proposal.destroy', $proposal->id ) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
