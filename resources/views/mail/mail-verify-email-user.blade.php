<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to OnlyMaiNails!</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="text-align: center;">
            <img src="https://onlymainails.alfonso-tenggono.online/img/transparant-logo-v2.png" style="height: 100px;" alt="OnlyMaiNails Logo" />
            <h1 style="color: #333;">Welcome to OnlyMaiNails!</h1>
        </div>

        <div style="margin: 20px 0; text-align: center;">
            <p>Dear <strong>User</strong>,</p>
            <p>We are thrilled to have you with us! To complete your registration, please verify your email address by clicking the link below:</p>
            <a href="{{ $mailData['url'] }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0;">Verify Email</a>
            <p>If the button above doesn't work, please copy and paste the following link into your browser:</p>
            <p>{{ $mailData['url'] }}</p>
            <p>Thank you for choosing OnlyMaiNails. We look forward to serving you!</p>
        </div>

        <footer style="border-top: 1px solid #eee; padding-top: 10px; text-align: center; color: #777;">
            <p>OnlyMaiNails</p>
            <p>Atelier House - 5885 Victoria Drive, Vancouver</p>
            <p>Email: <a href="mailto:maixesthetics@gmail.com">maixesthetics@gmail.com</a></p>
        </footer>
    </div>
</body>

</html>


