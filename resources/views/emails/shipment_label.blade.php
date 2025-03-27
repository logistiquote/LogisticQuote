<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Shipment Label</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="email-container" style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background-color: #f7f7f7;">
    <div class="email-header" style="background-color: #004aad; color: white; padding: 10px 20px;">
        <h2 style="margin: 0;">Your Shipment Label is Ready</h2>
    </div>

    <div style="background-color: white; padding: 20px;">
        <p>Dear {{ $userName }},</p>

        <p>Thank you for choosing our services.</p>

        <p>Your shipment has been successfully created. Shipment Number: {{ $trackingNumber }}</p>

        <p>Please find the attached shipment label. Kindly ensure that one label is affixed to each package.</p>

        <p>Best regards,</p>
        <p>The {{ config('app.name') }} Team</p>
    </div>

    <div class="email-footer" style="text-align: center; font-size: 12px; color: #888; padding-top: 10px;">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>

</html>
