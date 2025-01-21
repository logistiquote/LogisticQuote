<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Inquiry</title>
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
<div class="email-container">
    <div class="email-header">
        <h2>Thank You for Your Inquiry</h2>
    </div>

    <p>Dear {{ $userName }},</p>

    <p>Thank you for your inquiry.</p>

    <p>Unfortunately, we were unable to locate the correct quotation for you at this time. However, your request has been forwarded to our specialist, and you will receive the correct quotation via email and on your dashboard shortly.</p>

    <p>For your reference, your quotation number for follow-up is <span class="highlight">{{ $quotationNumber }}</span>.</p>

    <p>Best regards,</p>
    <p>The {{ config('app.name') }} Team</p>

    <div class="email-footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
