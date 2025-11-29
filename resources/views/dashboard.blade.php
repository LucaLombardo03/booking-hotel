<x-app-layout>
    <div style="margin-bottom: 20px;">
        <h1>Ciao, {{ Auth::user()->name }} 👋</h1>
    </div>

    @if (session('success'))
        <div
            style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #badbcc;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">

        <div style="flex: 1; min-width: 300px;">
            <div class="card">
                <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0;">✏️ Modifica Profilo</h3>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT') <label style="font-weight: bold; display: block; margin-top: 10px;">Nome e
                        Cognome</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required>

                    <label style="font-weight: bold; display: block; margin-top: 10px;">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required>

                    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
                    <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">Lascia vuoti i campi qui sotto se non
                        vuoi cambiare password.</p>

                    <label style="font-weight: bold; display: block;">Nuova Password</label>
                    <input type="password" name="password" placeholder="Minimo 8 caratteri">

                    <label style="font-weight: bold; display: block; margin-top: 10px;">Conferma Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ripeti la password">

                    <button type="submit" class="btn"
                        style="width: 100%; margin-top: 20px; background-color: #2c3e50;">💾 Salva Modifiche</button>
                </form>
            </div>
        </div>

        <div style="flex: 2; min-width: 300px;">
            <div class="card">
                <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0;">📅 Le tue Prenotazioni
                </h3>

                @if ($reservations->isEmpty())
                    <p style="color: #666; font-style: italic;">Non hai ancora effettuato nessuna prenotazione.</p>
                    <a href="{{ route('home') }}" class="btn" style="background-color: #27ae60;">Prenota ora</a>
                @else
                    <table>
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th>Hotel</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $res)
                                <tr>
                                    <td style="font-weight: bold;">{{ $res->hotel->name }}</td>
                                    <td>{{ $res->check_in->format('d/m/Y') }}</td>
                                    <td>{{ $res->check_out->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('hotel.show', $res->hotel_id) }}"
                                            style="color: #3498db; text-decoration: none; font-weight: bold;">
                                            Vedi Hotel
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
