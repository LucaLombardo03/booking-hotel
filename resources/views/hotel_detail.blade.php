<x-app-layout>
    <div class="detail-container">

        <div style="margin-bottom: 20px;">
            <a href="{{ route('home') }}"
                style="display: inline-flex; align-items: center; color: #718096; text-decoration: none; font-weight: 600;">
                &larr; Torna alla lista
            </a>
        </div>

        <div class="detail-card">

            @if ($hotel->images->count() > 0)
                <div class="carousel">
                    @foreach ($hotel->images as $img)
                        <img src="{{ asset($img->image_path) }}" alt="{{ $hotel->name }}" class="carousel-img">
                    @endforeach
                </div>
                <p style="text-align: center; color: #a0aec0; font-size: 0.8rem; margin: 5px 0 0 0;">(Scorri per altre
                    foto)</p>
            @endif

            <div class="detail-header">
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                    <div style="flex: 1;">
                        <h1 class="detail-title">{{ $hotel->name }}</h1>
                        <div style="color: #718096; font-size: 1.1rem; line-height: 1.6;">
                            <span class="badge-city">{{ $hotel->city }}</span>
                            <span class="badge-rooms">🏠 {{ $hotel->total_rooms }} Stanze</span>
                            <br>
                            📍 {{ $hotel->street }}, {{ $hotel->house_number }} <span style="color: #a0aec0;">—
                                {{ $hotel->zip_code }}</span>
                        </div>
                    </div>

                    <div class="detail-price-box">
                        <span
                            style="display: block; font-size: 0.85rem; text-transform: uppercase; color: #a0aec0; font-weight: bold;">Prezzo
                            a notte</span>
                        <span style="color: #27ae60; font-weight: 900; font-size: 2rem;">€ {{ $hotel->price }}</span>
                        @if ($hotel->tourist_tax > 0)
                            <div style="font-size: 0.8rem; color: #718096; font-weight: 600;">
                                + € {{ number_format($hotel->tourist_tax, 2) }} tassa
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div style="padding: 30px 40px; line-height: 1.8; color: #4a5568; font-size: 1.1rem;">
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #2d3748; margin-bottom: 10px;">Descrizione</h3>
                <p>{{ $hotel->description }}</p>
            </div>

            <div class="booking-section">

                @if (isset($bookedDates) && $bookedDates->count() > 0)
                    <div class="alert-box alert-error">
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <span style="font-size: 1.5rem; margin-right: 10px;">📅</span>
                            <h4 style="margin: 0; font-weight: 800;">Date NON disponibili</h4>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; gap: 10px;">
                            @foreach ($bookedDates as $booking)
                                <li
                                    style="background: white; padding: 5px 12px; border-radius: 6px; border: 1px solid #fc8181; font-size: 0.9rem;">
                                    Dal <strong>{{ $booking->check_in->format('d/m') }}</strong> al
                                    <strong>{{ $booking->check_out->format('d/m') }}</strong>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @auth
                    <div class="booking-card">
                        <h3
                            style="margin-top: 0; margin-bottom: 20px; font-weight: 800; color: #2d3748; font-size: 1.4rem;">
                            Prenota il tuo soggiorno
                        </h3>

                        @if ($errors->any())
                            <div class="alert-box alert-error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('reserve') }}" method="POST">
                            @csrf
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px;">
                                <div>
                                    <label class="input-label">Data Check-in</label>
                                    <input type="date" name="check_in" id="check_in" required class="modern-input">
                                </div>
                                <div>
                                    <label class="input-label">Data Check-out</label>
                                    <input type="date" name="check_out" id="check_out" required class="modern-input">
                                </div>
                            </div>

                            <div id="price-summary" class="price-summary">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <span style="color: #2f855a; font-weight: bold;">Notti selezionate:</span>
                                    <span id="total-nights" style="font-weight: bold; font-size: 1.1rem;">0</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #48bb78; padding-top: 10px; margin-top: 10px;">
                                    <span style="color: #2f855a; font-weight: 800; font-size: 1.2rem;">TOTALE DA
                                        PAGARE:</span>
                                    <span id="total-price" style="color: #2f855a; font-weight: 900; font-size: 1.5rem;">€
                                        0.00</span>
                                </div>
                                <div style="font-size: 0.8rem; color: #2f855a; margin-top: 5px; text-align: right;">
                                    (Include soggiorno + tasse)
                                </div>
                            </div>

                            <button type="submit" class="btn-book">✅ Conferma e Paga</button>
                        </form>
                    </div>
                @else
                    <div
                        style="text-align: center; padding: 40px; background-color: #fffaf0; color: #9c4221; border-radius: 16px; border: 2px dashed #ed8936;">
                        <h3 style="margin-top: 0; font-size: 1.3rem;">Vuoi prenotare questo hotel?</h3>
                        <p style="margin-bottom: 25px;">Accedi subito per selezionare le date.</p>
                        <a href="{{ route('login') }}" class="btn-primary" style="background-color: #ed8936;">🔐 Vai al
                            Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <script>
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const summaryBox = document.getElementById('price-summary');
        const totalNightsLabel = document.getElementById('total-nights');
        const totalPriceLabel = document.getElementById('total-price');

        // Prezzi passati da PHP a JS
        const pricePerNight = {{ $hotel->price }};
        const touristTax = {{ $hotel->tourist_tax ?? 0 }};

        function calculateTotal() {
            if (checkInInput.value && checkOutInput.value) {
                const start = new Date(checkInInput.value);
                const end = new Date(checkOutInput.value);
                const diffTime = end - start;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays > 0) {
                    const totalCost = (pricePerNight + touristTax) * diffDays;
                    totalNightsLabel.innerText = diffDays;
                    totalPriceLabel.innerText = '€ ' + totalCost.toFixed(2);
                    summaryBox.style.display = 'block';
                } else {
                    summaryBox.style.display = 'none';
                }
            }
        }

        if (checkInInput && checkOutInput) {
            checkInInput.addEventListener('change', function() {
                checkOutInput.min = this.value;
                calculateTotal();
            });
            checkOutInput.addEventListener('change', calculateTotal);
        }
    </script>
</x-app-layout>
