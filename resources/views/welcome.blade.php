<x-app-layout>
    <div
        style="background-color: white; padding: 50px 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 50px;">
        <h1 style="font-size: 3rem; font-weight: 800; color: #1a202c; margin-bottom: 15px; letter-spacing: -1px;">
            Trova il tuo Hotel ideale
        </h1>
        <p style="color: #718096; margin-bottom: 35px; font-size: 1.2rem;">
            Le migliori strutture al miglior prezzo, prenotabili in un click.
        </p>

        <form action="{{ route('home') }}" method="GET"
            style="max-width: 650px; margin: 0 auto; display: flex; gap: 10px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); padding: 8px; border-radius: 50px; background: white; border: 1px solid #e2e8f0;">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cerca per nome hotel o città..."
                style="flex: 1; border: none; padding: 15px 30px; border-radius: 50px; font-size: 1.1rem; outline: none; color: #4a5568;">

            <button class="btn"
                style="padding: 12px 35px; border-radius: 50px; font-weight: bold; background-color: #3182ce; border: none; color: white; cursor: pointer; transition: background 0.3s; font-size: 1.1rem;">
                Cerca
            </button>
        </form>

        @if (request('search'))
            <div style="margin-top: 20px;">
                <a href="{{ route('home') }}"
                    style="color: #e53e3e; text-decoration: none; font-weight: bold; font-size: 0.95rem; background: #fff5f5; padding: 5px 15px; border-radius: 20px;">
                    ❌ Rimuovi filtri
                </a>
            </div>
        @endif
    </div>

    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px 60px 20px;">

        @if ($hotels->isEmpty())
            <div style="text-align: center; padding: 60px; color: #a0aec0;">
                <div style="font-size: 4rem; margin-bottom: 10px;">🏨</div>
                <h3 style="font-size: 2rem; font-weight: bold; color: #4a5568;">Nessun hotel trovato.</h3>
                <p style="font-size: 1.1rem;">Prova a cercare una città diversa o controlla l'ortografia.</p>
                <a href="{{ route('home') }}"
                    style="display: inline-block; margin-top: 20px; color: #3182ce; text-decoration: underline; font-weight: bold;">Vedi
                    tutti gli hotel</a>
            </div>
        @else
            <div class="grid"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 40px;">
                @foreach ($hotels as $hotel)
                    <div class="hotel-card"
                        style="background: white; border-radius: 16px; overflow: hidden; border: 1px solid #edf2f7; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">

                        <div style="padding: 30px;">
                            <div style="margin-bottom: 15px;">
                                <h3
                                    style="font-size: 1.6rem; font-weight: 800; color: #2d3748; margin: 0; line-height: 1.2; margin-bottom: 10px;">
                                    {{ $hotel->name }}
                                </h3>

                                <span
                                    style="display: inline-block; background: #ebf8ff; color: #2b6cb0; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $hotel->city }}
                                </span>
                            </div>

                            <div style="color: #718096; font-size: 1rem; line-height: 1.6;">
                                📍 {{ $hotel->street }}, {{ $hotel->house_number }} <br>
                                <span
                                    style="color: #a0aec0; font-size: 0.9em; margin-left: 22px;">{{ $hotel->zip_code }}</span>
                            </div>
                        </div>

                        <div
                            style="background-color: #f8fafc; padding: 20px 30px; border-top: 1px solid #edf2f7; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span
                                    style="display: block; font-size: 0.75rem; text-transform: uppercase; color: #a0aec0; letter-spacing: 0.05em; font-weight: bold;">Prezzo
                                    a notte</span>
                                <span style="color: #27ae60; font-weight: 900; font-size: 1.5rem;">€
                                    {{ $hotel->price }}</span>
                            </div>

                            <a href="{{ route('hotel.show', $hotel->id) }}" class="btn-detail"
                                style="background-color: #3182ce; color: white; padding: 12px 25px; border-radius: 10px; text-decoration: none; font-weight: bold; font-size: 0.95rem; transition: background 0.2s; box-shadow: 0 4px 6px rgba(49, 130, 206, 0.2);">
                                Vedi Dettagli &rarr;
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .hotel-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .hotel-card:hover {
            transform: translateY(-8px);
            /* La card si alza */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #bee3f8;
        }

        .btn:hover {
            background-color: #2b6cb0 !important;
        }

        .btn-detail:hover {
            background-color: #2c5282 !important;
            box-shadow: 0 6px 8px rgba(44, 82, 130, 0.3) !important;
        }

        input:focus {
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.3);
            /* Alone blu quando scrivi */
        }
    </style>
</x-app-layout>
