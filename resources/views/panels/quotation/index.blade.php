@extends('panels.layouts.master')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Quotations</h1>
        <a href="{{ route('quotation.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add Quotation
        </a>
    </div>
    <p class="mb-4"> View status of your quotations.</p>

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
                            <th width="10%">Transportation</th>
                            <th width="13%">Ready to load</th>
                            <th>Worth</th>
                            <th width="10%">Gross Weight</th>
                            <th>Paid</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotations as $quotation)
                        <tr>
                            <td> <b>{{ $quotation->quotation_id }} </b> </td>
                            <td>
                                <span class="text-success">{{ $quotation->route?->full_origin_location }}</span>
                                to
                                <span class="text-danger">{{ $quotation->route?->full_destination_location }}</span>
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
                                @if(!$quotation->is_paid)
                                    <form action="{{ route('payment.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="provider" value="paypal">
                                        <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                                        <button type="submit" class="btn btn-primary">Pay with PayPal</button>
                                    </form>

                                    <div class="mt-1">
                                        <button class="btn btn-primary" id="showInfoButton" data-bs-toggle="modal" data-bs-target="#ibanInfoModal">
                                            Show IBAN Info
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="ibanInfoModal" tabindex="-1" aria-labelledby="ibanInfoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ibanInfoModalLabel">Bank account details</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                            <tr>
                                                                <th>IBAN in print format</th>
                                                                <td>IL62 0108 0000 0009 9999 999</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Country code</th>
                                                                <td>IL</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Check digits</th>
                                                                <td>62</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bank code</th>
                                                                <td>010</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Branch code</th>
                                                                <td>800</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bank account number</th>
                                                                <td>000009999999999</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge badge-success">Paid</span>
                                @endif
                            </td>
                            <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success fa-2x" data-toggle="dropdown">
                                    <i class="fad fa-ellipsis-v-alt"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('quotation.show', $quotation->id) }}">View</a>
                                    <a class="dropdown-item" href="{{ route('quotation.edit', $quotation->id) }}">Edit</a>

                                    @if( $quotation->status != 'withdrawn')
                                        <form action="{{ route('quotation.destroy', $quotation->id ) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#publish">
                                                Withdraw
                                            </button>
                                        </form>
                                    @else
                                        <!-- Button trigger modal -->
                                        <!-- <button type="button" class="dropdown-item" data-toggle="modal" data-target="#publish">
                                            Publish
                                        </button> -->
                                    @endif
                                </div>
                            </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


@endsection

@section('bottom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready( function () {
        $('#quotations_table').DataTable();
    });
</script>
@endsection
