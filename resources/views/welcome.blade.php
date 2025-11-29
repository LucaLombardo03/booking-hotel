<x-app-layout>
    <div style="text-align: center; margin-bottom: 30px;">
        <h1>Trova il tuo Hotel ideale</h1>
        <form action="{{ route('home') }}" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cerca hotel o città..."
                style="width: 50%; display: inline-block;">
            <button class="btn">Cerca</button>

            @if (request('search'))
                <br>
                <a href="{{ route('home') }}" style="color: red; font-size: 0.9em; text-decoration: underline;">Rimuovi
                    filtri</a>
            @endif
        </form>
    </div>

    @if ($hotels->isEmpty())
        <div style="text-align: center; margin-top: 50px; color: #7f8c8d;">
            <h3>😔 Nessun hotel trovato.</h3>
            <p>Prova a cercare qualcos'altro o <a href="{{ route('home') }}" style="color: blue;">vedi tutti gli
                    hotel</a>.</p>
        </div>
    @else
        <div class="grid">
            @foreach ($hotels as $hotel)
                <div class="card">
                    <h3>{{ $hotel->name }}</h3>
                    <p>{{ $hotel->city }}</p>
                    <p class="price">€ {{ $hotel->price }}</p>
                    <a href="{{ route('hotel.show', $hotel->id) }}" class="btn">Vedi Dettagli</a>
                </div>
            @endforeach
        </div>
    @endif

</x-app-layout>
