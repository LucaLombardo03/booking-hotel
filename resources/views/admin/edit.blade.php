<x-app-layout>
    <div style="max-width: 900px; margin: 40px auto; padding: 0 20px;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a202c; margin: 0;">Modifica Hotel</h1>
            <a href="{{ route('admin.home') }}"
                style="color: #718096; text-decoration: none; font-weight: bold; display: flex; align-items: center;">
                &larr; Annulla e Torna Indietro
            </a>
        </div>

        <div class="admin-card">
            <h3 class="card-title">✏️ Modifica Dati: <span style="color: #3182ce;">{{ $hotel->name }}</span></h3>

            <form action="{{ route('admin.hotel.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 30px; border-bottom: 1px solid #edf2f7; padding-bottom: 20px;">
                    <label class="input-label" style="margin-bottom: 15px;">🖼️ Gestione Foto</label>

                    @if($hotel->images->count() > 0)
                        <div style="display: flex; gap: 10px; overflow-x: auto; margin-bottom: 15px; padding-bottom: 10px;">
                            @foreach($hotel->images as $img)
                                <img src="{{ asset($img->image_path) }}" 
                                     style="width: 100px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @endforeach
                        </div>
                    @else
                        <p style="color: #a0aec0; font-size: 0.9rem; margin-bottom: 15px;">Nessuna foto caricata.</p>
                    @endif

                    <div style="border: 2px dashed #cbd5e0; background: #f7fafc; padding: 15px; border-radius: 8px;">
                        <label class="input-label" style="margin-bottom: 5px; color: #4a5568;">➕ Aggiungi altre foto</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="modern-input" 
                               style="border: none; background: transparent; padding: 0;">
                        <p style="font-size: 0.8rem; color: #718096; margin-top: 5px;">
                            Le nuove immagini verranno aggiunte a quelle esistenti.
                        </p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label class="input-label">Nome Hotel</label>
                        <input type="text" name="name" value="{{ $hotel->name }}" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">N. Stanze</label>
                        <input type="number" name="total_rooms" value="{{ $hotel->total_rooms }}" required class="modern-input" min="1">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label class="input-label">Prezzo (€)</label>
                        <input type="number" name="price" value="{{ $hotel->price }}" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">Tassa Soggiorno (€)</label>
                        <input type="number" step="0.50" name="tourist_tax" value="{{ $hotel->tourist_tax }}"
                            placeholder="0.00" class="modern-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label class="input-label">Via / Piazza</label>
                        <input type="text" name="street" value="{{ $hotel->street }}" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">N. Civico</label>
                        <input type="text" name="house_number" value="{{ $hotel->house_number }}" required
                            class="modern-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label class="input-label">Città</label>
                        <input type="text" name="city" value="{{ $hotel->city }}" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">CAP</label>
                        <input type="text" name="zip_code" value="{{ $hotel->zip_code }}" required
                            class="modern-input">
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <label class="input-label">Descrizione</label>
                    <textarea name="description" class="modern-input" style="height: 120px; resize: vertical;">{{ $hotel->description }}</textarea>
                </div>

                <div style="text-align: right;">
                    <button class="btn-save">💾 Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .admin-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 40px;
            border: 1px solid #edf2f7;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 30px;
            border-bottom: 2px solid #f7fafc;
            padding-bottom: 20px;
        }

        .modern-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            outline: none;
            transition: 0.2s;
            color: #4a5568;
            font-size: 1rem;
        }

        .modern-input:focus {
            border-color: #f6ad55;
            box-shadow: 0 0 0 3px rgba(246, 173, 85, 0.2);
        }

        .input-label {
            display: block;
            font-weight: bold;
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-save {
            background: #ed8936;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            font-size: 1rem;
        }

        .btn-save:hover {
            background: #dd6b20;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(221, 107, 32, 0.2);
        }
    </style>
</x-app-layout>