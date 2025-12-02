<x-app-layout>
    <div style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; color: #1a202c; margin: 0;">Dashboard Admin</h1>
                <p style="color: #718096; margin-top: 5px;">Gestisci strutture, stanze e prenotazioni.</p>
            </div>
            <a href="{{ route('admin.users') }}" class="btn-secondary">
                👥 Gestisci Utenti
            </a>
        </div>

        @if(session('success'))
            <div style="background:#c6f6d5; color:#22543d; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #9ae6b4;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:#fed7d7; color:#822727; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #feb2b2;">
                <ul>@foreach($errors->all() as $error) <li>❌ {{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <div class="admin-card" style="margin-bottom: 40px;">
            <h3 class="card-title">🏨 Aggiungi Nuovo Hotel</h3>

            <form action="{{ route('admin.hotel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 25px;">
                    <label class="input-label">📸 Foto Hotel (Seleziona più file)</label>
                    <div style="border: 2px dashed #e2e8f0; background: #f7fafc; padding: 15px; border-radius: 8px;">
                        <input type="file" name="images[]" multiple accept="image/*" class="modern-input" style="border: none; background: transparent;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label class="input-label">Nome Hotel</label>
                        <input type="text" name="name" placeholder="Es. Grand Hotel" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">N. Stanze</label>
                        <input type="number" name="total_rooms" placeholder="Es. 10" required class="modern-input" min="1">
                    </div>
                    <div>
                        <label class="input-label">Prezzo (€)</label>
                        <input type="number" name="price" placeholder="Es. 120" required class="modern-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
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
                        <input type="number" step="0.50" name="tourist_tax" placeholder="Es. 2.50" class="modern-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
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

        <div class="admin-card">
            <h3 class="card-title">📋 Lista Hotel Attivi</h3>

            @if ($hotels->isEmpty())
                <p style="color: #a0aec0; text-align: center; padding: 20px;">Nessun hotel presente.</p>
            @else
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
                                <td style="font-weight: bold; color: #2d3748;">
                                    {{ $hotel->name }}
                                    <div style="font-weight: normal; font-size: 0.8rem; color: #718096; margin-top: 2px;">
                                        🏠 {{ $hotel->total_rooms }} Stanze
                                    </div>
                                </td>
                                <td style="color: #718096;">
                                    {{ $hotel->city }} <span style="font-size: 0.8em;">({{ $hotel->street }})</span>
                                </td>
                                <td>
                                    <span
                                        style="background: #ebf8ff; color: #2b6cb0; padding: 4px 10px; border-radius: 20px; font-weight: bold; font-size: 0.85rem;">
                                        {{ $hotel->reservations_count }} attive
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <a href="{{ route('admin.hotel.edit', $hotel->id) }}"
                                            class="action-btn btn-edit">Modifica</a>

                                        <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST"
                                            onsubmit="return confirm('Sicuro?');">
                                            @csrf @method('DELETE')
                                            <button class="action-btn btn-delete">Elimina</button>
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

    <style>
        .admin-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 30px;
            border: 1px solid #edf2f7;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 25px;
            border-bottom: 2px solid #f7fafc;
            padding-bottom: 15px;
        }

        .modern-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            outline: none;
            transition: 0.2s;
            color: #4a5568;
        }

        .modern-input:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        .input-label {
            display: block;
            font-weight: bold;
            font-size: 0.85rem;
            color: #4a5568;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: #3182ce;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #2c5282;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #718096;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: 0.2s;
        }

        .btn-secondary:hover {
            background: #4a5568;
        }

        /* Tabella */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            text-align: left;
            padding: 15px;
            color: #718096;
            font-size: 0.85rem;
            text-transform: uppercase;
            border-bottom: 2px solid #edf2f7;
        }

        .admin-table td {
            padding: 15px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: bold;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-edit {
            background: #ecc94b;
            color: #744210;
        }

        .btn-edit:hover {
            background: #d69e2e;
        }

        .btn-delete {
            background: #fc8181;
            color: #742a2a;
        }

        .btn-delete:hover {
            background: #e53e3e;
            color: white;
        }
    </style>
</x-app-layout>