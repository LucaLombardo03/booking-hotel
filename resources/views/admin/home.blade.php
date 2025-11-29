<x-app-layout>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <a href="{{ route('admin.users') }}" class="btn">Gestisci Utenti</a>

        <div class="card">
            <h3>Aggiungi Hotel</h3>
            <form action="{{ route('admin.hotel.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nome" required>
                <input type="text" name="city" placeholder="Città" required>
                <input type="number" name="price" placeholder="Prezzo" required>
                <textarea name="description" placeholder="Descrizione"></textarea>
                <button class="btn">Aggiungi</button>
            </form>
        </div>

        <div class="card">
            <h3>Lista Hotel</h3>
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Città</th>
                    <th>Prenotazioni</th>
                    <th>Azioni</th>
                </tr>
                @foreach ($hotels as $hotel)
                    <tr>
                        <td>{{ $hotel->name }}</td>
                        <td>{{ $hotel->city }}</td>
                        <td>{{ $hotel->reservations_count }}</td>
                        <td>
                            <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn" style="background:red">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>
