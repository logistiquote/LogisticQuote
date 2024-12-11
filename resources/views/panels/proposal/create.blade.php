@extends('panels.layouts.master')
@section('content')


<div class="row">
    <div class="col-xl-8 col-md-8 mb-4 offset-md-2">
        <div class="card card shadow">
            <h5 class="card-header">Make Proposal for <b class="text-warning">quotation#{{ $quotation->quotation_id }} </b> </h5>
            <div class="card-body">

                <form action="{{ route('proposal.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <!-- <h6> Origin local charges (USD) </h6> -->
                            <input type="number" class="form-control @error('local_charges') is-invalid @enderror"
                                id="validationServer03" placeholder="Origin local charges (USD)" value="{{ old('local_charges') }}" name="local_charges" required>
                            @error('local_charges')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <!-- <h6> Freight Charges(USD) </h6> -->
                            <input type="number" class="form-control @error('freight_charges') is-invalid @enderror"
                                id="validationServer04" placeholder="Freight Charges(USD)" name="freight_charges" required>
                            @error('freight_charges')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <!-- <h6> Destination local charges </h6> -->
                            <input type="number" class="form-control @error('destination_local_charges') is-invalid @enderror"
                                id="validationServer03" placeholder="Destination local charges" value="{{ old('destination_local_charges') }}" name="destination_local_charges" required>
                            @error('destination_local_charges')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <!-- <h6> Customs Clearance(USD) </h6> -->
                            <input type="number" class="form-control @error('customs_clearance_charges') is-invalid @enderror"
                                id="validationServer04" placeholder="Customs Clearance(USD)" name="customs_clearance_charges" required>
                            @error('customs_clearance_charges')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationServer01">Valid till:</label>
                            <input type="text" class="form-control" name="valid_till" value="" required />

                        </div>
                    </div>

                    <hr>
                    <h5 class="mt-4"> <b> Other Info </b> </h5>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            
                            <label for="exampleFormControlTextarea1">Remarks</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remarks"></textarea>
                            @error('value_of_goods')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Make Proposal</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection


@section('bottom_scripts')
<script>
    $(function () {
        $('input[name="valid_till"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: parseInt(moment().format('YYYY'), 10),
                autoApply: true,
                maxYear: 2050,
                locale: {
                    format: 'D-M-YYYY'
                }
            }
        );
    });

</script>
@endsection