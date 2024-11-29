@extends('panels.layouts.master')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

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
<script>
    $(document).ready( function () {
        $('#quotations_table').DataTable();
    });
</script>
@endsection