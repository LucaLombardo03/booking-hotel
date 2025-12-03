<x-app-layout>
    <style>
        .detail-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .detail-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            height: 400px;
            border-bottom: 1px solid #edf2f7;
        }

        .carousel-img {
            min-width: 100%;
            height: 100%;
            object-fit: cover;
            scroll-snap-align: start;
        }

        .carousel::-webkit-scrollbar {
            display: none;
        }

        .detail-header {
            padding: 40px 40px 20px 40px;
            border-bottom: 1px solid #edf2f7;
        }

        .detail-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a202c;
            margin: 0;
            line-height: 1.1;
            margin-bottom: 15px;
        }

        .badge-city {
            display: inline-block;
            background: #ebf8ff;
            color: #2b6cb0;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .badge-rooms {
            display: inline-block;
            background: #e6fffa;
            color: #285e61;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-left: 8px;
            margin-bottom: 10px;
        }

        .detail-price-box {
            text-align: right;
            background: #f7fafc;
            padding: 15px 25px;
            border-radius: 16px;
        }

        .booking-section {
            background-color: #f8fafc;
            padding: 40px;
            border-top: 1px solid #edf2f7;
        }

        .alert-box {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-error {
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
        }

        .booking-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .input-label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #4a5568;
            font-size: 0.9rem;
        }

        .modern-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e0;
            border-radius: 10px;
            font-size: 1rem;
            color: #2d3748;
            outline: none;
            transition: all 0.2s;
        }

        .modern-input:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.2);
        }

        .price-summary {
            display: none;
            background-color: #f0fff4;
            border: 1px solid #c6f6d5;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .btn-book {
            width: 100%;
            padding: 15px;
            background-color: #3182ce;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 800;
            transition: all 0.2s;
            box-shadow: 0 4px 6px rgba(49, 130, 206, 0.3);
        }

        .btn-book:hover {
            background-color: #2c5282;
            transform: translateY(-2px);
        }

        .btn-primary {
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            color: white;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

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

                @if (isset($bookedDates) && $bookedDates->count() > 0 && $hotel->total_rooms == 1)
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
                                <ul style="margin: 0; padding-left: 20px;">
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

                                @if ($hotel->total_rooms > 1)
                                    <div id="rooms-availability-box"
                                        style="display:none; margin-bottom: 15px; padding: 10px; background: #ebf8ff; border-radius: 8px; color: #2b6cb0; font-weight: bold; font-size: 0.95rem; text-align: center;">
                                        <span id="rooms-left-text"></span>
                                    </div>
                                @endif
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

        // Elementi per la gestione disponibilità
        const availabilityBox = document.getElementById('rooms-availability-box');
        const roomsLeftText = document.getElementById('rooms-left-text');
        const btnBook = document.querySelector('.btn-book');

        // Dati da PHP
        const pricePerNight = {{ $hotel->price }};
        const touristTax = {{ $hotel->tourist_tax ?? 0 }};
        const hotelId = {{ $hotel->id }};

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

                    // --- CHIAMATA AJAX (Se esiste il box) ---
                    if (availabilityBox) {
                        checkAvailability(checkInInput.value, checkOutInput.value);
                    }
                } else {
                    summaryBox.style.display = 'none';
                }
            }
        }

        function checkAvailability(checkIn, checkOut) {
            // Reset grafico
            availabilityBox.style.display = 'block';
            roomsLeftText.innerText = "Verifica disponibilità...";
            availabilityBox.style.background = "#ebf8ff"; // Blu
            availabilityBox.style.color = "#2b6cb0";

            if (btnBook) {
                btnBook.disabled = true;
                btnBook.classList.add('btn-disabled');
            }

            // Chiamata API
            fetch(`/check-availability?hotel_id=${hotelId}&check_in=${checkIn}&check_out=${checkOut}`)
                .then(response => response.json())
                .then(data => {
                    const left = data.rooms_left;

                    if (left === 0) {
                        // ESAURITO
                        availabilityBox.style.background = "#fff5f5"; // Rosso chiaro
                        availabilityBox.style.color = "#c53030"; // Rosso scuro
                        roomsLeftText.innerText = "❌ Nessuna stanza disponibile per queste date!";
                        // Lasciamo il bottone disabilitato
                    } else if (left <= 3) {
                        // POCHE STANZE
                        availabilityBox.style.background = "#fffaf0"; // Arancio chiaro
                        availabilityBox.style.color = "#c05621"; // Arancio scuro
                        roomsLeftText.innerText = `🔥 Affrettati! Solo ${left} stanze rimanenti.`;
                        enableButton();
                    } else {
                        // DISPONIBILE
                        availabilityBox.style.background = "#f0fff4"; // Verde chiaro
                        availabilityBox.style.color = "#2f855a"; // Verde scuro
                        roomsLeftText.innerText = `✅ Disponibilità confermata (${left} stanze libere).`;
                        enableButton();
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    roomsLeftText.innerText = "Impossibile verificare disponibilità.";
                    enableButton(); // Nel dubbio abilitiamo, il backend controllerà comunque
                });
        }

        function enableButton() {
            if (btnBook) {
                btnBook.disabled = false;
                btnBook.classList.remove('btn-disabled');
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
