<x-app-layout>
    <div style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">

        <div style="margin-bottom: 30px;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a202c;">Ciao, {{ Auth::user()->name }} 👋</h1>
            <p style="color: #718096;">Gestisci il tuo profilo e visualizza i tuoi viaggi.</p>
        </div>

        @if (session('success'))
            <div
                style="background-color: #f0fff4; color: #276749; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #c6f6d5; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">

            <div
                style="background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #edf2f7;">
                <h3
                    style="font-size: 1.25rem; font-weight: 700; color: #2d3748; margin-bottom: 25px; display: flex; align-items: center;">
                    <span style="background: #ebf8ff; padding: 8px; border-radius: 10px; margin-right: 10px;">👤</span>
                    I tuoi Dati
                </h3>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; font-weight: bold; margin-bottom: 8px; color: #4a5568; font-size: 0.9rem;">Nome
                            Completo</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required
                            class="modern-input">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; font-weight: bold; margin-bottom: 8px; color: #4a5568; font-size: 0.9rem;">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                            class="modern-input">
                    </div>

                    <div style="background: #f7fafc; padding: 20px; border-radius: 12px; margin-bottom: 25px;">
                        <p style="font-size: 0.85rem; color: #718096; margin-bottom: 15px; font-weight: bold;">🔒 Cambio
                            Password (Opzionale)</p>

                        <div style="margin-bottom: 15px;">
                            <input type="password" name="password" placeholder="Nuova Password" class="modern-input">
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Conferma Password"
                                class="modern-input">
                        </div>
                    </div>

                    <button class="btn-primary" style="width: 100%;">Salva Modifiche</button>
                </form>

                <div style="margin-top: 40px; padding-top: 25px; border-top: 1px dashed #e2e8f0;">
                    <h4 style="color: #c53030; font-size: 0.9rem; font-weight: bold; margin-bottom: 10px;">Zona Pericolo
                    </h4>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('SEI SICURO? Questa azione è irreversibile.');">
                        @csrf
                        @method('DELETE')
                        <button
                            style="width: 100%; background: #fff5f5; border: 1px solid #feb2b2; color: #c53030; padding: 10px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                            🗑️ Elimina Account
                        </button>
                    </form>
                </div>
            </div>

            <div
                style="background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #edf2f7;">
                <h3
                    style="font-size: 1.25rem; font-weight: 700; color: #2d3748; margin-bottom: 25px; display: flex; align-items: center;">
                    <span style="background: #f0fff4; padding: 8px; border-radius: 10px; margin-right: 10px;">📅</span>
                    Le tue Prenotazioni
                </h3>

                @if ($reservations->isEmpty())
                    <div
                        style="text-align: center; padding: 40px; color: #a0aec0; background: #f7fafc; border-radius: 12px;">
                        <p>Non hai ancora viaggi in programma.</p>
                        <a href="{{ route('home') }}"
                            style="color: #3182ce; font-weight: bold; text-decoration: none; margin-top: 10px; display: inline-block;">Prenota
                            ora &rarr;</a>
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                            <thead>
                                <tr
                                    style="background-color: #f7fafc; color: #718096; font-size: 0.85rem; text-align: left;">
                                    <th style="padding: 12px; border-radius: 8px 0 0 8px;">Hotel</th>
                                    <th style="padding: 12px;">Date</th>
                                    <th style="padding: 12px; border-radius: 0 8px 8px 0;">Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $res)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px 12px; font-weight: bold; color: #2d3748;">
                                            {{ $res->hotel->name }}</td>
                                        <td style="padding: 15px 12px; font-size: 0.9rem; color: #4a5568;">
                                            {{ $res->check_in->format('d/m') }} ➝ {{ $res->check_out->format('d/m/Y') }}
                                        </td>
                                        <td style="padding: 15px 12px;">
                                            <a href="{{ route('hotel.show', $res->hotel_id) }}"
                                                style="color: #3182ce; text-decoration: none; font-weight: bold; font-size: 0.9rem;">Vedi</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <style>
        .modern-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            transition: all 0.2s;
            color: #2d3748;
        }

        .modern-input:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        .btn-primary {
            background-color: #3182ce;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background-color: #2c5282;
        }
    </style>
</x-app-layout>
