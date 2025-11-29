<x-app-layout>
    <div
        style="max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">

        <h1 style="font-size: 2.5em; margin-bottom: 10px;">{{ $hotel->name }}</h1>
        <h3 style="color: #7f8c8d; margin-bottom: 20px;">
            📍 {{ $hotel->city }} &nbsp;|&nbsp;
            <span style="color: #27ae60; font-weight: bold;">€ {{ $hotel->price }} / notte</span>
        </h3>

        <div style="line-height: 1.6; color: #333; margin-bottom: 30px;">
            <p>{{ $hotel->description }}</p>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

        @if (isset($bookedDates) && $bookedDates->count() > 0)
            <div
                style="background-color: #fff5f5; border: 1px solid #feb2b2; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="color: #c53030; margin-top: 0;">📅 Date NON disponibili:</h4>
                <ul style="color: #c53030; list-style: circle; margin-left: 20px;">
                    @foreach ($bookedDates as $booking)
                        <li>Dal <strong>{{ $booking->check_in->format('d/m/Y') }}</strong> al
                            <strong>{{ $booking->check_out->format('d/m/Y') }}</strong></li>
                    @endforeach
                </ul>
            </div>
        @endif

        @auth
            @if ($errors->any())
                <div
                    style="background-color: #c53030; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 style="margin-bottom: 15px;">Prenota il tuo soggiorno</h3>

            <form action="{{ route('reserve') }}" method="POST"
                style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
                @csrf
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Data Check-in</label>
                        <input type="date" name="check_in" id="check_in" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Data Check-out</label>
                        <input type="date" name="check_out" id="check_out" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-green"
                    style="width: 100%; padding: 12px; background-color: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    ✅ Conferma Prenotazione
                </button>
            </form>
        @else
            <div
                style="text-align: center; padding: 20px; background-color: #fff3cd; color: #856404; border-radius: 8px; border: 1px solid #ffeeba;">
                Devi prima effettuare il <a href="{{ route('login') }}"
                    style="text-decoration: underline; font-weight: bold; color: #856404;">Login</a> per prenotare.
            </div>
        @endauth

        <div style="margin-top: 20px;">
            <a href="{{ route('home') }}" style="color: #3498db; text-decoration: none;">&larr; Torna alla lista
                hotel</a>
        </div>
    </div>

    <script>
        // Prende gli elementi dal DOM
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');

        if (checkInInput && checkOutInput) {
            // Quando cambi la data di Check-in
            checkInInput.addEventListener('change', function() {
                // Imposta la data minima del Check-out uguale alla data scelta per il Check-in
                checkOutInput.min = this.value;

                // Se la data di check-out attuale è precedente al nuovo check-in, la resetta
                if (checkOutInput.value && checkOutInput.value < this.value) {
                    checkOutInput.value = this.value;
                }
            });
        }
    </script>
</x-app-layout>
