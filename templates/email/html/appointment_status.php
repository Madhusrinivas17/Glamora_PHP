<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Glamora Appointment Status Update</title>
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
        }
        .header h1 span {
            color: #E87A90;
        }
        .content {
            padding: 35px 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .status-Confirmed { background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7; }
        .status-Completed { background: #E3F2FD; color: #1565C0; border: 1px solid #90CAF9; }
        .status-Cancelled { background: #FFEBEE; color: #C62828; border: 1px solid #EF9A9A; }
        .details-box {
            background: #FDF0F3;
            border: 1px solid #F3D8E0;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .details-row:last-child {
            margin-bottom: 0;
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
            <div class="status-badge status-<?= h($status) ?>">
                Appointment <?= h($status) ?>
            </div>

            <h3 style="color: #4A1525; margin-top: 0;">Hello, <?= h($name) ?></h3>

            <?php if ($status === 'Confirmed'): ?>
                <p>Your Glamora appointment has been confirmed.</p>
            <?php elseif ($status === 'Completed'): ?>
                <p>Thank you for visiting Glamora.</p>
                <p>Your appointment has been marked as completed.</p>
            <?php elseif ($status === 'Cancelled'): ?>
                <p>Your appointment has been cancelled.</p>
                <p>If you have any questions, please contact Glamora.</p>
            <?php else: ?>
                <p>Your appointment status has been updated to <strong><?= h($status) ?></strong>.</p>
            <?php endif; ?>

            <div class="details-box">
                <div class="details-row">
                    <strong>Service:</strong>
                    <span><?= h($serviceName) ?></span>
                </div>
                <div class="details-row">
                    <strong>Date:</strong>
                    <span><?= h($appointmentDate) ?></span>
                </div>
                <div class="details-row">
                    <strong>Time:</strong>
                    <span><?= h($appointmentTime) ?></span>
                </div>
            </div>

            <?php if ($status === 'Confirmed'): ?>
                <p style="font-weight: 600; color: #4A1525;">We look forward to serving you.</p>
            <?php elseif ($status === 'Completed'): ?>
                <p style="font-weight: 600; color: #4A1525;">We hope to see you again.</p>
            <?php endif; ?>
        </div>
        <div class="footer">
            &copy; <?= date('Y') ?> Glamora Salon Management. All rights reserved.
        </div>
    </div>
</body>
</html>
