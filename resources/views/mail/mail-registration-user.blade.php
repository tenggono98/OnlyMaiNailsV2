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
            <img src="https://onlymainails.alfonso-tenggono.online/img/transparant-logo.png" style="height: 100px;" alt="OnlyMaiNails Logo" />
            <h1 style="color: #333;">Welcome to OnlyMaiNails</h1>
        </div>

        <div style="margin: 20px 0; text-align: center;">
            <p>Dear <strong>{{ $mailData['clientName'] }}</strong>,</p>
            <p>Thank you for registering on our website. Your password is <strong>{{ $mailData['password'] }}</strong>. Please change it as soon as you log in to avoid account hijacking.</p>
            <p>You can log in to your account using the following link:</p>
            <p>{{ route('user.login')  }}</p>
            <p>Thank you for choosing OnlyMaiNails. We look forward to serving you!</p>
        </div>

        <footer style="border-top: 1px solid #eee; padding-top: 10px; text-align: center; color: #777;">
            <p>OnlyMaiNails</p>
            <p>{{ $mailData['address'] }}</p>
            <p>Email: <a href="mailto:{{ $mailData['mail'] }}">{{ $mailData['mail'] }}</a></p>
        </footer>
    </div>
</body>

</html>


