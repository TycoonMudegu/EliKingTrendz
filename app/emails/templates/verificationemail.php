<?php

$VerificationEmail ='
<!DOCTYPE html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #4CAF50;
        }
        .content {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your Email</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>Thank you for signing up! Please use the following verification code to complete your registration:</p>
            <h2 style="font-size: 24px; color: #4CAF50;">{{verificationCode}}</h2>
            <p>If you did not request this, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p>The Apple Junction Team</p>
        </div>
    </div>
</body>
';
