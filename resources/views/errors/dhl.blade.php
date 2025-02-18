@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-danger">DHL API Error</h2>
        <p>{{ $message }}</p>
    </div>
@endsection
