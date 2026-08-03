<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Glamora OTP Verification</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #FFFAFB;
            margin: 0;
            padding: 0;
            color: #2B181E;
        }
        .container {
            max-width: 580px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #F3D8E0;
            box-shadow: 0 10px 30px rgba(74, 21, 37, 0.08);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4A1525 0%, #7A2E44 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .header h1 span {
            color: #E87A90;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #4A1525;
            margin-bottom: 15px;
        }
        .text {
            font-size: 14px;
            color: #6E5860;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        .otp-box {
            display: inline-block;
            background: #FDF0F3;
            border: 2px dashed #E87A90;
            border-radius: 14px;
            padding: 18px 40px;
            margin: 15px 0 25px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #E87A90;
            font-family: 'Courier New', Courier, monospace;
        }
        .badge {
            display: inline-block;
            background: #E87A90;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 50px;
            text-transform: uppercase;
        }
        .footer {
            background: #FFFAFB;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #F3D8E0;
            font-size: 12px;
            color: #8E7880;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Glam<span>ora</span></h1>
            <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.85;">Luxury Salon & Beauty Management</p>
        </div>
        <div class="content">
            <div class="greeting">Welcome to Glamora, <?= h($name) ?>!</div>
            <div class="text">
                Thank you for registering your <?= h(ucfirst($role)) ?> account. To complete your registration and activate your account, please enter the 6-digit Email Verification OTP code below:
            </div>
            
            <div class="otp-box">
                <div class="otp-code"><?= h($otpCode) ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <span class="badge">Valid for <?= (int)$expiryMinutes ?> Minutes</span>
            </div>

            <div class="text" style="font-size: 12px; color: #9E8890;">
                🔒 <strong>Security Warning:</strong> Never share this OTP code with anyone. Glamora support will never ask for your verification code.
            </div>
        </div>
        <div class="footer">
            &copy; <?= date('Y') ?> Glamora Salon Management. All rights reserved.<br>
            If you did not request this registration, please safely ignore this email.
        </div>
    </div>
</body>
</html>
