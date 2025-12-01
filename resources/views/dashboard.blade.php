<x-app-layout>
    <div style="width: 95%; max-width: 1600px; margin: 40px auto; padding: 0 20px;">

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

        <div class="dashboard-grid">

            <div class="card-box">
                <h3 class="card-title">
                    <span class="icon-bg">👤</span> I tuoi Dati
                </h3>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 20px;">
                        <label class="input-label">Nome Completo</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required
                            class="modern-input">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="input-label">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                            class="modern-input">
                    </div>

                    <div style="background: #f7fafc; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                        <p style="font-size: 0.8rem; color: #718096; margin-bottom: 10px; font-weight: bold;">🔒 Cambio
                            Password</p>
                        <div style="margin-bottom: 10px;">
                            <input type="password" name="password" placeholder="Nuova Password" class="modern-input">
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Conferma"
                                class="modern-input">
                        </div>
                    </div>

                    <button class="btn-primary" style="width: 100%;">Salva</button>
                </form>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('SEI SICURO? Questa azione è irreversibile.');">
                        @csrf @method('DELETE')
                        <button class="btn-danger">🗑️ Elimina Account</button>
                    </form>
                </div>
            </div>

            <div class="card-box" style="padding: 0; overflow: hidden;">
                <div style="padding: 25px; border-bottom: 1px solid #f1f5f9;">
                    <h3 class="card-title" style="margin: 0;">
                        <span class="icon-bg" style="background: #f0fff4; color: #276749;">📅</span> Le tue Prenotazioni
                    </h3>
                </div>

                @if ($reservations->isEmpty())
                    <div style="text-align: center; padding: 60px 20px; color: #a0aec0;">
                        <p>Non hai ancora viaggi in programma.</p>
                        <a href="{{ route('home') }}" class="btn-link"
                            style="background: #3182ce; color: white; padding: 10px 20px; border-radius: 50px; display:inline-block; margin-top:10px;">Prenota
                            ora &rarr;</a>
                    </div>
                @else
                    <div>
                        <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                            <thead>
                                <tr
                                    style="background-color: #f8fafc; color: #64748b; font-size: 0.8rem; text-transform: uppercase; text-align: left;">
                                    <th style="padding: 15px 20px; width: 35%;">Hotel</th>
                                    <th style="padding: 15px; width: 30%;">Viaggio</th>
                                    <th style="padding: 15px; width: 20%;">Totale</th>
                                    <th style="padding: 15px 20px; text-align: right; width: 15%;">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $res)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 20px; vertical-align: middle; word-wrap: break-word;">
                                            <div
                                                style="font-weight: 800; color: #1e293b; font-size: 1rem; line-height: 1.2;">
                                                {{ $res->hotel->name }}</div>
                                            <div style="font-size: 0.85rem; color: #64748b; margin-top: 4px;">📍
                                                {{ $res->hotel->city }}</div>
                                        </td>

                                        <td style="padding: 20px 15px; vertical-align: middle;">
                                            <div
                                                style="font-weight: 600; color: #334155; font-size: 0.95rem; line-height: 1.4;">
                                                {{ $res->check_in->format('d/m/y') }} <br>
                                                <span style="color: #cbd5e0;">↓</span> <br>
                                                {{ $res->check_out->format('d/m/y') }}
                                            </div>
                                            <div
                                                style="font-size: 0.8rem; color: #94a3b8; margin-top: 5px; font-weight: 500;">
                                                🌙 {{ $res->check_in->diffInDays($res->check_out) }} notti
                                            </div>
                                        </td>

                                        <td style="padding: 20px 15px; vertical-align: middle;">
                                            <div style="font-weight: 800; color: #059669; font-size: 1.1rem;">
                                                € {{ number_format($res->total_price, 2) }}
                                            </div>
                                        </td>

                                        <td style="padding: 20px 20px; text-align: right; vertical-align: middle;">
                                            <a href="{{ route('hotel.show', $res->hotel_id) }}"
                                                style="color: #3182ce; background: #ebf8ff; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 0.85rem; transition: all 0.2s; display: inline-block;">
                                                Vedi
                                            </a>
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
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        @media (min-width: 1024px) {
            .dashboard-grid {
                /* Colonna sinistra ridotta al minimo, tutto il resto alla tabella */
                grid-template-columns: 300px 1fr;
                gap: 40px;
            }
        }

        .card-box {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 30px;
            border: 1px solid #edf2f7;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .icon-bg {
            background: #ebf8ff;
            padding: 10px;
            border-radius: 12px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .modern-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            transition: 0.2s;
            color: #2d3748;
            box-sizing: border-box;
        }

        .modern-input:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        .input-label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #4a5568;
            font-size: 0.85rem;
        }

        .btn-primary {
            background-color: #3182ce;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background-color: #2c5282;
        }

        .btn-danger {
            width: 100%;
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 10px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.9rem;
        }

        .btn-danger:hover {
            background: #fed7d7;
        }

        .btn-link {
            color: white;
            text-decoration: none;
            font-weight: 700;
            transition: background 0.2s;
        }

        .btn-link:hover {
            background-color: #2c5282;
        }
    </style>
</x-app-layout>
