<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso - Booking Hotel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body style="background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh;">

    <div style="width: 100%; max-width: 400px; padding: 20px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="/" class="logo"
                style="font-size: 30px; text-decoration: none; color: #2c3e50; font-weight: bold;">
                BookingHotel
            </a>
        </div>

        <div class="card"
            style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            {{ $slot }}
        </div>
    </div>

</body>

</html>
