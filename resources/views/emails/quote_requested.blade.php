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
    <p>A new quote has been requested by a user please review and make a proposal:</p>
    <table>
        <tr>
            <th>Quotation No.</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Type</th>
            <th>Gross Weight (kg)</th>
            <th>Ready to load</th>
            <th>View Quotation</th>
        </tr>
        
        <tr>
            <td>{{ $quotation['quotation_id'] }}</td>
            <td>{{ $quotation['origin'] }}</td>
            <td>{{ $quotation['destination'] }}</td>
            <td>{{ $quotation['transportation_type'] }} ({{ $quotation['type'] }})</td>
            <td>{{ $quotation['total_weight'] }}</td>
            <td>
                <?php
                    $date = Carbon\Carbon::parse($quotation['ready_to_load_date']);
                    echo $date->format('M d Y');
                ?>
            </td>
            <td>
                <a href="{{ URL::route('quotation.mail_view', $quotation['quotation_id']) }}" alt="View Quotation">
                    View Quotation
                </a>
            </td>
        </tr>
        
    </table>
</body>
</html>