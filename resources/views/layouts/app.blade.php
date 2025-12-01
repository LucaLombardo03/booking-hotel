<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Hotel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* RESET E BASE */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding-bottom: 40px;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: 0.3s;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* NAVBAR PRINCIPALE */
        .main-navbar {
            background-color: #2c3e50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main-navbar .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            color: rgba(255, 255, 255, 0.8);
            margin-left: 20px;
            font-weight: 500;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: white;
        }

        /* Bottone Logout */
        .btn-logout {
            background: none;
            border: none;
            color: #e74c3c;
            cursor: pointer;
            font-weight: bold;
            margin-left: 20px;
            padding: 0;
            font-size: 1rem;
        }

        .btn-logout:hover {
            color: #ff6b6b;
            text-decoration: underline;
        }

        /* Container Generale */
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Fix per evitare conflitti tra Bootstrap e il tuo CSS */
        a.btn {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <nav class="main-navbar">
        <div class="logo">BookingHotel</div>

        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>

            @auth
                <a href="{{ route('dashboard') }}">Profilo</a>

                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.home') }}" style="color: #f1c40f;">Area Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Registrati</a>
            @endauth
        </div>
    </nav>

    <div class="container-custom">
        {{ $slot }}
    </div>

</body>

</html>
