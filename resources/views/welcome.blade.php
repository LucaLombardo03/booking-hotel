<x-app-layout>
    <div style="text-align: center; margin-bottom: 40px; padding-top: 20px;">
        <h1 style="font-size: 2.5rem; margin-bottom: 20px; color: #1a202c;">Trova il tuo Hotel ideale</h1>

        <form action="{{ route('home') }}" method="GET"
            style="max-width: 600px; margin: 0 auto; display: flex; gap: 10px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cerca hotel o città..."
                style="flex: 1; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px; font-size: 1rem;">

            <button class="btn" style="padding: 12px 25px; font-size: 1rem; border-radius: 8px;">Cerca</button>
        </form>

        @if (request('search'))
            <div style="margin-top: 10px;">
                <a href="{{ route('home') }}" style="color: #e53e3e; text-decoration: underline; font-size: 0.9rem;">❌
                    Rimuovi filtri ricerca</a>
            </div>
        @endif
    </div>

    @if ($hotels->isEmpty())
        <div style="text-align: center; margin-top: 50px; color: #718096;">
            <h3 style="font-size: 1.5rem;">😔 Nessun hotel trovato.</h3>
            <p>Prova a cercare qualcos'altro.</p>
        </div>
    @else
        <div class="grid"
            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
            @foreach ($hotels as $hotel)
                <div class="card"
                    style="display: flex; flex-direction: column; justify-content: space-between; height: 100%; padding: 25px; transition: transform 0.2s; border: 1px solid #e2e8f0;">

                    <div>
                        <h3 style="font-size: 1.6rem; margin-top: 0; margin-bottom: 10px; color: #2d3748;">
                            {{ $hotel->name }}
                        </h3>

                        <div style="color: #718096; font-size: 0.95rem; margin-bottom: 20px; line-height: 1.5;">
                            📍 {{ $hotel->street }}, {{ $hotel->house_number }}<br>
                            &nbsp;&nbsp;&nbsp;&nbsp; {{ $hotel->zip_code }} - <strong>{{ $hotel->city }}</strong>
                        </div>
                    </div>

                    <div
                        style="border-top: 1px solid #edf2f7; padding-top: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <span style="display: block; font-size: 0.8rem; color: #a0aec0;">Prezzo per notte</span>
                            <span style="color: #27ae60; font-weight: bold; font-size: 1.4rem;">€
                                {{ $hotel->price }}</span>
                        </div>

                        <a href="{{ route('hotel.show', $hotel->id) }}" class="btn"
                            style="background-color: #3182ce; padding: 10px 20px; border-radius: 6px;">
                            Vedi Dettagli
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
