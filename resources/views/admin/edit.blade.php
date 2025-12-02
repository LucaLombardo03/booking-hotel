<x-app-layout>
    <div class="page-container" style="max-width: 900px;">

        <div class="page-header">
            <h1 class="page-title">Modifica Hotel</h1>
            <a href="{{ route('admin.home') }}" class="back-link">&larr; Annulla e Torna Indietro</a>
        </div>

        <div class="card-box">
            <h3 class="card-title">✏️ Modifica Dati: <span
                    style="color: #3182ce; margin-left: 10px;">{{ $hotel->name }}</span></h3>

            <form action="{{ route('admin.hotel.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="img-manage-container">
                    <label class="input-label" style="margin-bottom: 15px;">🖼️ Gestione Foto</label>

                    @if ($hotel->images->count() > 0)
                        <div class="img-preview-list">
                            @foreach ($hotel->images as $img)
                                <img src="{{ asset($img->image_path) }}" class="img-preview-thumb">
                            @endforeach
                        </div>
                    @else
                        <p style="color: #a0aec0; font-size: 0.9rem; margin-bottom: 15px;">Nessuna foto caricata.</p>
                    @endif

                    <div class="upload-box">
                        <label class="input-label" style="margin-bottom: 5px; color: #4a5568;">➕ Aggiungi altre
                            foto</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="upload-input">
                        <p style="font-size: 0.8rem; color: #718096; margin-top: 5px;">Le nuove immagini verranno
                            aggiunte a quelle esistenti.</p>
                    </div>
                </div>

                <div class="form-grid-3-1">
                    <div>
                        <label class="input-label">Nome Hotel</label>
                        <input type="text" name="name" value="{{ $hotel->name }}" required class="modern-input">
                    </div>
                    <div>
                        <label class="input-label">N. Stanze</label>
                        <input type="number" name="total_rooms" value="{{ $hotel->total_rooms }}" required
                            class="modern-input" min="1">
                    </div>
                </div>

                <div class="form-grid-2">
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

                <div class="form-grid-3-1">
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

                <div class="form-grid-3-1">
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
</x-app-layout>
