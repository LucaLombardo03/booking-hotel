<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Hotel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <nav>
        <div class="logo">BookingHotel</div>
        <div>
            <a href="{{ route('home') }}">Home</a>

            @auth
                <a href="{{ route('dashboard') }}">Profilo</a>

                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.home') }}" style="color:red;">Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit"
                        style="background:none; border:none; color:red; cursor:pointer; font-weight:bold; margin-left:15px;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Registrati</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        {{ $slot }}
    </div>
</body>

</html>
