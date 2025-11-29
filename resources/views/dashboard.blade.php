<x-app-layout>
    <div class="container">
        <h1>Ciao, {{ Auth::user()->name }}</h1>
        <div class="card">
            <h3>Le tue prenotazioni</h3>
            <table>
                <tr><th>Hotel</th><th>Dal</th><th>Al</th></tr>
                @foreach($reservations as $res)
                <tr>
                    <td>{{ $res->hotel->name }}</td>
                    <td>{{ $res->check_in->format('d/m/Y') }}</td>
                    <td>{{ $res->check_out->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>