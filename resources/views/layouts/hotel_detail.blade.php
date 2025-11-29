<x-app-layout>
    <div class="container card">
        <h1>{{ $hotel->name }}</h1>
        <h3>{{ $hotel->city }} - € {{ $hotel->price }}/notte</h3>
        <p>{{ $hotel->description }}</p>
        <hr>
        @auth
            <h3>Prenota</h3>
            <form action="{{ route('reserve') }}" method="POST">
                @csrf
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                Check-in: <input type="date" name="check_in" required>
                Check-out: <input type="date" name="check_out" required>
                <button class="btn">Conferma</button>
            </form>
        @else
            <p style="color:red">Devi fare login per prenotare.</p>
        @endauth
    </div>
</x-app-layout>