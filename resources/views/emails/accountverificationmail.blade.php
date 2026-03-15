<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Account Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #ffffff; padding: 20px;">
    <div style="max-width: 500px; margin: auto; text-align: center; background: #ffffff; border-radius: 12px; padding: 30px;">
        <h2 style="color:#4F39F6;">Verify Your Account</h2>
        <p>Click the button below to verify your email address:</p>
        <a href="{{ $verificationUrl }}" 
           style="display:inline-block; padding: 12px 25px; background:#4F39F6; color:#ffffff; border-radius:8px; text-decoration:none; font-weight:bold; margin:20px 0;">
           Verify Email
        </a>
        <p>If the button doesn't work, copy and paste this link in your browser:</p>
        <p style="word-break: break-all;"><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
    </div>
</body>
</html>