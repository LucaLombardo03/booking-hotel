<x-app-layout>
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
            <h1>Admin Dashboard</h1>
            <a href="{{ route('admin.users') }}" class="btn" style="background-color: #6c757d;">Gestisci Utenti</a>
        </div>

        <!-- FORM DI AGGIUNTA HOTEL -->
        <div class="card" style="margin-bottom: 30px;">
            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Aggiungi Nuovo Hotel
            </h3>

            <form action="{{ route('admin.hotel.store') }}" method="POST">
                @csrf

                <!-- RIGA 1: Nome e Prezzo -->
                <div style="display:flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 3;">
                        <label style="font-weight: bold; font-size: 0.9em;">Nome Hotel</label>
                        <input type="text" name="name" placeholder="Es. Hotel Roma" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold; font-size: 0.9em;">Prezzo per notte (€)</label>
                        <input type="number" name="price" placeholder="Es. 80" required>
                    </div>
                </div>

                <!-- RIGA 2: Indirizzo (Via e Civico) -->
                <div style="display:flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 3;">
                        <label style="font-weight: bold; font-size: 0.9em;">Via / Piazza</label>
                        <input type="text" name="street" placeholder="Es. Via Garibaldi" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold; font-size: 0.9em;">N. Civico</label>
                        <input type="text" name="house_number" placeholder="Es. 42/B" required>
                    </div>
                </div>

                <!-- RIGA 3: Città e CAP -->
                <div style="display:flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 3;">
                        <label style="font-weight: bold; font-size: 0.9em;">Città</label>
                        <input type="text" name="city" placeholder="Es. Milano" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold; font-size: 0.9em;">CAP</label>
                        <input type="text" name="zip_code" placeholder="Es. 20100" required>
                    </div>
                </div>

                <!-- Descrizione -->
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; font-size: 0.9em;">Descrizione</label>
                    <textarea name="description" placeholder="Inserisci una descrizione dell'hotel..." style="height: 80px;"></textarea>
                </div>

                <button class="btn" style="background-color: #27ae60; width: 100%;">Salva Hotel</button>
            </form>
        </div>

        <!-- LISTA HOTEL ESISTENTI -->
        <div class="card">
            <h3>Lista Hotel</h3>
            @if ($hotels->isEmpty())
                <p>Nessun hotel inserito.</p>
            @else
                <table>
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>Nome</th>
                            <th>Indirizzo</th> <!-- Ho unito Città e Via qui per compattezza -->
                            <th>Prenotazioni</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotels as $hotel)
                            <tr>
                                <td style="font-weight: bold;">{{ $hotel->name }}</td>
                                <td>
                                    {{ $hotel->city }} ({{ $hotel->zip_code }})<br>
                                    <span style="font-size: 0.8em; color: #666;">{{ $hotel->street }},
                                        {{ $hotel->house_number }}</span>
                                </td>
                                <td>{{ $hotel->reservations_count }}</td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('admin.hotel.edit', $hotel->id) }}" class="btn"
                                            style="background: #f39c12; padding: 5px 10px; font-size: 0.8em; text-decoration: none; color: white; border-radius: 4px;">
                                            Modifica
                                        </a>

                                        <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST"
                                            onsubmit="return confirm('Sei sicuro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn"
                                                style="background: #e74c3c; padding: 5px 10px; font-size: 0.8em; margin: 0;">Elimina</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
