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

                    <span class="badge">{{ $quotation->quote_number }}</span>

                </h5>
                <div class="card-body">
                    <form role="form" action="{{ route('quotation.update', $quotation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if($quotation->route)
                            @include('panels.quotation.ocean-view', ['quotation' => $quotation])
                        @elseif($quotation->shipment)
                            @include('panels.quotation.air-view', ['quotation' => $quotation])
                        @endif
                        @if(Auth::user()->role === 'admin')
                            <button type="submit" class="btn btn-primary">Update</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
