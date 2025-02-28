@extends('frontend.layouts.app')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #333;
            color: #fff;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            font-size: 14px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: #0056b3;
        }

    </style>
    <div class="container">
        <h2>DHL Shipping Quote</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($quote['products']) && count($quote['products']) > 0)
            <table>
                <thead>
                <tr>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Delivery Time</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($quote['products'] as $service)
                    <tr>
                        <td><strong>{{ $service['productName'] }}</strong></td>
                        <td style="color: green;">${{ $service['totalPrice'] }} {{ $service['currency'] }}</td>
                        <td>{{ $service['deliveryTime'] ?? 'N/A' }}</td>
                        <td>
                            <form action="{{ route('dhl.shipment') }}" method="GET">
                                @csrf
                                <input type="hidden" name="service_type" value="{{ $service['productCode'] }}">
                                <button type="submit" class="btn">Select</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">
                <strong>No shipping options available.</strong> Please try again.
            </div>
        @endif
    </div>
@endsection
