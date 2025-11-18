<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .info-box {
            background-color: #fff;
            border-left: 4px solid #4CAF50;
            padding: 15px;
            margin: 20px 0;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
        .procedure-steps {
            background-color: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .procedure-steps ol {
            padding-left: 20px;
        }
        .procedure-steps li {
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Reservation Successful!</h1>
    </div>
    
        <div class="content">
        <p>Dear {{ implode(' ', [
            $reservation->customer->fname,
            $reservation->customer->mi,
            $reservation->customer->lname,
            $reservation->customer->suffix,
        ]) }},</p>

        
        <p>Thank you for your reservation! We're pleased to confirm that your lot reservation has been successfully submitted.</p>
        
        <div class="info-box">
            <h3>Reservation Details:</h3>
            <p><strong>Lot Number:</strong> {{ $reservation->lot->lot_number ?? 'N/A' }}</p>
            <p><strong>Downpayment Amount:</strong> ₱{{ number_format($reservation->total_downpayment_price, 2) }}</p>
            <p><strong>Reserved Date:</strong> {{ $reservation->reserved_at->format('F d, Y h:i A') }}</p>
            <p><strong>Expires On:</strong> {{ $reservation->expires_at->format('F d, Y h:i A') }}</p>
            <p><strong>Status:</strong> <span style="color: #ffc107;">Pending Verification</span></p>
        </div>

        <div class="warning-box">
            <strong>⚠️ Important:</strong> Your reservation will expire in 24 hours if payment is not verified. Please complete the verification process as soon as possible.
        </div>

        <div class="procedure-steps">
            <h3>Next Steps - Payment Verification Procedure:</h3>
            <ol>
                <li><strong>Visit Our Office:</strong> Please come to our office during business hours (Monday-Friday, 8:00 AM - 5:00 PM).</li>
                <li><strong>Bring Required Documents:</strong>
                    <ul>
                        <li>Valid Government-issued ID</li>
                        <li>Original payment receipt/proof of payment</li>
                        <li>This confirmation email (printed or on your phone)</li>
                    </ul>
                </li>
                <li><strong>Meet with Our Admin Team:</strong> Our staff will verify your payment and reservation details.</li>
                <li><strong>Payment Confirmation:</strong> Once verified, your reservation status will be updated and you'll receive a confirmation.</li>
                <li><strong>Finalize Documentation:</strong> Complete any additional paperwork required for your lot purchase.</li>
            </ol>
        </div>

        <div class="info-box">
            <h3>Office Address:</h3>
            <p>
                7XVC+6PQ, Juanito R. Remulla Senior Rd, Dasmariñas, Cavite
            </p>
        </div>

        <p>If you have any questions or concerns, please don't hesitate to contact us.</p>
        
        <p>Best regards,<br>
        <strong>Providence Memorial Park Team</strong></p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Providence Memorial Park. All rights reserved.</p>
    </div>
</body>
</html>