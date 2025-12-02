<x-app-layout>
    <div class="page-container" style="max-width: 1200px;">

        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard Admin</h1>
                <p class="page-subtitle">Gestisci strutture, stanze e prenotazioni.</p>
            </div>
            <a href="{{ route('admin.users') }}" class="btn-secondary">👥 Gestisci Utenti</a>
        </div>

        @if (session('success'))
            <div class="alert-box alert-success">✅ {{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert-box alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-box">
            <h3 class="card-title">🏨 Aggiungi Nuovo Hotel</h3>

            <form action="{{ route('admin.hotel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 25px;">
                    <label class="input-label">📸 Foto Hotel (Seleziona più file)</label>
                    <div class="upload-box">
                        <input type="file" name="images[]" multiple accept="image/*" class="upload-input">
                    </div>
                </div>

                <div class="form-grid-3">
                    <div>
                        <label class="input-label">Nome Hotel</label>
                        <input type="text" name="name" placeholder="Es. Grand Hotel" required
                            class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">N. Stanze</label>
                        <input type="number" name="total_rooms" placeholder="Es. 10" required class="modern-input"
                            min="1">
                    </div>
                    <div>
                        <label class="input-label">Prezzo (€)</label>
                        <input type="number" name="price" placeholder="Es. 120" required class="modern-input">
                    </div>
                </div>

                <div class="form-grid-3">
                    <div>
                        <label class="input-label">Città</label>
                        <input type="text" name="city" placeholder="Milano" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">CAP</label>
                        <input type="text" name="zip_code" placeholder="20100" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">Tassa Soggiorno (€)</label>
                        <input type="number" step="0.50" name="tourist_tax" placeholder="Es. 2.50"
                            class="modern-input">
                    </div>
                </div>

                <div class="form-grid-3-1">
                    <div>
                        <label class="input-label">Via / Piazza</label>
                        <input type="text" name="street" placeholder="Es. Via Roma" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">N. Civico</label>
                        <input type="text" name="house_number" placeholder="10" required class="modern-input">
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label class="input-label">Descrizione</label>
                    <textarea name="description" placeholder="Descrivi la struttura..." class="modern-input"
                        style="height: 100px; resize: vertical;"></textarea>
                </div>

                <div style="text-align: right;">
                    <button class="btn-primary">Salva Struttura</button>
                </div>
            </form>
        </div>

        <div class="card-box">
            <h3 class="card-title">📋 Lista Hotel Attivi</h3>

            @if ($hotels->isEmpty())
                <p style="color: #a0aec0; text-align: center; padding: 20px;">Nessun hotel presente.</p>
            @else
                <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Località</th>
                                <th>Prenotazioni</th>
                                <th style="text-align: right;">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotels as $hotel)
                                <tr>
                                    <td>
                                        <div style="font-weight: bold; color: #2d3748;">{{ $hotel->name }}</div>
                                        <div style="font-size: 0.8rem; color: #718096; margin-top: 2px;">🏠
                                            {{ $hotel->total_rooms }} Stanze</div>
                                    </td>
                                    <td style="color: #718096;">
                                        {{ $hotel->city }} <span
                                            style="font-size: 0.8em;">({{ $hotel->street }})</span>
                                    </td>
                                    <td>
                                        <span class="badge-count">{{ $hotel->reservations_count }} attive</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div class="action-btn-group">
                                            <a href="{{ route('admin.hotel.edit', $hotel->id) }}"
                                                class="btn-action btn-action-edit">Modifica</a>
                                            <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST"
                                                onsubmit="return confirm('Sicuro?');">
                                                @csrf @method('DELETE')
                                                <button class="btn-action btn-action-delete">Elimina</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
