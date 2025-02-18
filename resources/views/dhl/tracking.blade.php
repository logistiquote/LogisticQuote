@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <h2>Shipment Tracking</h2>
        <p>Your shipment is on its way! Track it using the tracking number below:</p>

        <h4>Tracking Number: <strong>{{ $tracking_number }}</strong></h4>
    </div>
@endsection
