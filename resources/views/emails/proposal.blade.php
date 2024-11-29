<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <h2>Dear Customer,</h2>
    <p>Please see below rates for your quotation:</p>
    <table>
        <tr>
            <th>Vendor Name</th>
            <th>Origin local charges (USD)</th>
            <th>Freight Charges (USD)</th>
            <th>Destination local charges (USD)</th>
            <th>Customs Clearance (USD)</th>
            <th>Total (USD)</th>
            <th>View Proposal</th>
        </tr>
        @foreach($proposals as $proposal)
        <tr>
            <td>{{ $proposal['vendor']['name'] }}</td>
            <td>{{ $proposal['local_charges'] }}</td>
            <td>{{ $proposal['freight_charges'] }}</td>
            <td>{{ $proposal['destination_local_charges'] }}</td>
            <td>{{ $proposal['customs_clearance_charges'] }}</td>
            <td>{{ $proposal['total'] }}</td>
            <td>
                <a href="{{ URL::route('proposal.mail_view', $proposal['url']) }}" alt="View Proposal">
                    View Proposal
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>