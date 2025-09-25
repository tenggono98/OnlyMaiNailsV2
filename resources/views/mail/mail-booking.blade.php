<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Global resets */
        img {
            border: none;
            max-width: 100%;
        }

        body {
            background-color: #eaebed !important;
            font-family: sans-serif;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
        }

        /* Container */
        .container {
            max-width: 580px;
            margin: 0 auto;
            padding: 10px;
            width: 100%;
        }

        /* Main content area */
        .main {
            background: #ffffff !important;
            border-radius: 3px;
            width: 100%;
            padding: 20px;
            box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1), 0px 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Typography */
        h1 {
            font-size: 28px;
            font-weight: 300;
            text-align: center;
            margin-bottom: 30px;
        }

        p, ul, ol {
            margin: 0 0 15px 0;
            padding: 0;
        }

        a {
            color: #ec0867;
            text-decoration: underline;
        }

        /* Button styles */
        .btn {
            display: inline-block;
            background-color: #ec0867;
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin: 10px 0;

        }

        /* Responsive styles */
        @media only screen and (max-width: 620px) {
            body {
                font-size: 16px;
            }

            .container-info{
              padding-left:0 !important;
            }

            .container {
                width: 100%;
                padding: 0;
            }

            .main {
                padding: 10px;
            }

            .btn {
                width: 80%;
                padding: 10px;
            }

            table td {

                width: auto;
            }


        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main">
            <table>
                <tr>
                    <td style="text-align: center;">
                        <img src="{{ asset('img/logo-v2.png') }}" style="height: auto; max-width: 100%;" alt="OnlyMaiNails Logo" />
                        <p style="margin-top: 10px; ">{{ $company['name'] }}</p>
                        <p style="margin: 0;">{{ $company['address'] }}</p>
                        <p style="margin: 0;">Email: {{ $company['email'] }}</p>
                    </td>
                </tr>
            </table>
            <div class="container-info" style="text-align: left; color: #4b5563; margin-top: 20px;padding-left:10%">
                <table style="width: 100%; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 40px;">
                            <img src="https://img.icons8.com/?size=100&id=86305&format=png&color=000000" style="width: 24px; height: 24px;" alt="Icon">
                        </td>
                        <td>
                            <p style="margin: 0;">Appointment Schedule for</p>
                            <p style=" margin: 0;">{{ $mailData['clientName'] }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40px;">
                            <img src="https://img.icons8.com/?size=100&id=42763&format=png&color=000000" style="width: 24px; height: 24px;" alt="Icon">
                        </td>
                        <td>
                            <p style="margin: 0;">Service</p>
                            <ul style="padding-left: 0; list-style: none; margin: 0;">
                                @foreach ($mailData['services'] as $item)
                                <li style=" margin: 0;">({{ $item['service']['category']['name_service_categori'] }}) {{ $item['name_service'] }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40px;">
                            <img src="https://img.icons8.com/?size=100&id=UTe6yKq2hvHK&format=png&color=000000" style="width: 24px; height: 24px;" alt="Icon">
                        </td>
                        <td>
                            <p style="margin: 0;">Date & Time</p>
                            <p style=" margin: 0;">{{ $mailData['booking_date'] }} | {{ $mailData['booking_time'] }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40px;">
                            <img src="https://img.icons8.com/?size=100&id=11676&format=png&color=000000" style="width: 24px; height: 24px;" alt="Icon">
                        </td>
                        <td>
                            <p style="margin: 0;">Reschedule or Cancel Appointment</p>
                            <p style="margin: 0;">
                                <a href="{{ route('user.reschedule_or_cancel',['uuid' => $mailData['uuid']])  }}" target="_blank" class="btn">Click Here</a>
                            </p>
                            <p style="margin: 0;">{{ route('user.reschedule_or_cancel',['uuid' => $mailData['uuid']])  }}</p>
                        </td>
                    </tr>
                </table>
                <p style="font-size: 0.875rem;">We've attached a little guide, with more details about our services and tips to make the most of your visit. We hope you find it helpful!</p>
            </div>
        </div>
    </div>
</body>

</html>
