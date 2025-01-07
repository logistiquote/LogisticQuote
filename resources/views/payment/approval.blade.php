@extends('layouts.app')

@section('content')
    <h1>Payment Approval</h1>
    <p>Click the button below to approve the payment.</p>
    <a href="{{ $approvalUrl }}" class="btn btn-primary">Approve Payment</a>
@endsection
