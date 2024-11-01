<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OTP Verification</title>
</head>
<body>
    <p>Dear {{ $user->username }},</p>
    <p>Your OTP code is: <strong>{{ $otpCode }}</strong></p>
    <p>Please use this code to verify your login.</p>
    <p>If you did not request this verification code, please ignore this email.</p>
    <p>Best regards,<br>Kusoya-IFMS</p>
</body>
</html>
