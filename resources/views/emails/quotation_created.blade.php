<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
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
<h2>A new quote has been requested by a user. Please review and make a proposal:</h2>
<table>
    <tr>
        <th>Quotation No.</th>
        <th>Origin</th>
        <th>Destination</th>
        <th>Type</th>
        <th>Ready to load</th>
    </tr>
    <tr>
        <td>{{ $quotation['quotation_id'] }}</td>
        <td>{{ $quotation['origin'] }}</td>
        <td>{{ $quotation['destination'] }}</td>
        <td>{{ $quotation['transportation_type'] }} ({{ $quotation['type'] }})</td>
        <td>{{ \Carbon\Carbon::parse($quotation['ready_to_load_date'])->format('M d Y') }}</td>
    </tr>
</table>
</body>
</html>
