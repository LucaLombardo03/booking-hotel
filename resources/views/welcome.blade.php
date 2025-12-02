<x-app-layout>
    <div class="hero-section">
        <h1 class="hero-title">Trova il tuo Hotel ideale</h1>
        <p style="color: #718096; margin-bottom: 35px; font-size: 1.2rem;">
            Le migliori strutture al miglior prezzo, prenotabili in un click.
        </p>

        <form action="{{ route('home') }}" method="GET" class="search-bar-container">

            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cerca per nome hotel o città..." class="search-input">

            <button class="btn-search">Cerca</button>
        </form>

        @if (request('search'))
            <div>
                <a href="{{ route('home') }}" class="remove-filters">❌ Rimuovi filtri</a>
            </div>
        @endif
    </div>

    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px 60px 20px;">

        @if ($hotels->isEmpty())
            <div style="text-align: center; padding: 60px; color: #a0aec0;">
                <div style="font-size: 4rem; margin-bottom: 10px;">🏨</div>
                <h3 style="font-size: 2rem; font-weight: bold; color: #4a5568;">Nessun hotel trovato.</h3>
                <p style="font-size: 1.1rem;">Prova a cercare una città diversa.</p>
                <a href="{{ route('home') }}"
                    style="display: inline-block; margin-top: 20px; color: #3182ce; font-weight: bold;">
                    Vedi tutti gli hotel
                </a>
            </div>
        @else
            @if (request('search'))
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: #f7fafc; padding: 15px 20px; border-radius: 12px; border: 1px solid #edf2f7; flex-wrap: wrap; gap: 10px;">
                    <div style="color: #4a5568;">
                        Risultati per: <strong>"{{ request('search') }}"</strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 0.9rem; font-weight: bold; color: #718096;">Ordina Prezzo:</span>
                        <a href="{{ route('home', ['search' => request('search'), 'sort' => 'price_asc']) }}"
                            class="btn-primary" style="padding: 6px 15px; font-size: 0.9rem;">⬇️ Basso</a>
                        <a href="{{ route('home', ['search' => request('search'), 'sort' => 'price_desc']) }}"
                            class="btn-primary" style="padding: 6px 15px; font-size: 0.9rem;">⬆️ Alto</a>
                    </div>
                </div>
            @endif

            <div class="hotel-grid">
                @foreach ($hotels as $hotel)
                    <div class="hotel-card">
                        <div class="hotel-image-box">
                            @if ($hotel->relationLoaded('images') && $hotel->images->count() > 0)
                                <img src="{{ asset($hotel->images->first()->image_path) }}" alt="{{ $hotel->name }}"
                                    class="hotel-image">
                            @else
                                <div
                                    style="height: 100%; display: flex; align-items: center; justify-content: center; color: #a0aec0; flex-direction: column;">
                                    <span style="font-size: 2rem;">📷</span><span>No Foto</span>
                                </div>
                            @endif
                        </div>

                        <div class="hotel-content">
                            <div style="margin-bottom: 15px;">
                                <h3 class="hotel-name">{{ $hotel->name }}</h3>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <span class="badge-city">{{ $hotel->city }}</span>
                                    <span class="badge-rooms">🏠 {{ $hotel->total_rooms ?? 1 }} Stanze</span>
                                </div>
                            </div>
                            <div style="color: #718096;">
                                📍 {{ $hotel->street }}, {{ $hotel->house_number }} <br>
                                <span
                                    style="color: #a0aec0; font-size: 0.9em; margin-left: 22px;">{{ $hotel->zip_code }}</span>
                            </div>
                        </div>

                        <div class="hotel-footer">
                            <div>
                                <span
                                    style="display: block; font-size: 0.75rem; text-transform: uppercase; color: #a0aec0; font-weight: bold;">Prezzo
                                    a notte</span>
                                <span class="price-big">€ {{ $hotel->price }}</span>
                                @if ($hotel->tourist_tax > 0)
                                    <div style="font-size: 0.7rem; color: #a0aec0;">+ €
                                        {{ number_format($hotel->tourist_tax, 2) }} tassa</div>
                                @endif
                            </div>
                            <a href="{{ route('hotel.show', $hotel->id) }}" class="btn-primary">Vedi Dettagli
                                &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 50px; display: flex; justify-content: center;">
                {{ $hotels->withQueryString()->links() }}
            </div>

        @endif
    </div>
</x-app-layout>
