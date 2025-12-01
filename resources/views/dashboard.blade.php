<x-app-layout>
    <div style="max-width: 1400px; margin: 40px auto; padding: 0 20px;">

        <div style="margin-bottom: 30px;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a202c; margin: 0;">Ciao, {{ Auth::user()->name }} 👋
            </h1>
            <p style="color: #718096; margin-top: 5px;">Gestisci il tuo profilo e i tuoi viaggi.</p>
        </div>

        @if (session('success'))
            <div
                style="background-color: #f0fff4; color: #276749; padding: 15px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #c6f6d5; box-shadow: 0 2px 4px rgba(0,0,0,0.05); font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                style="background-color: #fff5f5; color: #c53030; padding: 15px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #feb2b2; font-weight: 600;">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <div class="dashboard-grid">

            <div class="card-box profile-card">
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

                    <div
                        style="background: #f8fafc; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
                        <p
                            style="font-size: 0.85rem; color: #718096; margin-bottom: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                            🔒 Cambio Password</p>

                        <div style="margin-bottom: 12px;">
                            <input type="password" name="password" placeholder="Nuova Password" class="modern-input">
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Conferma Password"
                                class="modern-input">
                        </div>
                    </div>

                    <button class="btn-primary" style="width: 100%;">Salva Modifiche</button>
                </form>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 2px dashed #e2e8f0;">
                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('SEI SICURO? Questa azione è irreversibile.');">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger">🗑️ Elimina Account</button>
                    </form>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 30px;">

                <div class="card-box" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="padding: 25px; border-bottom: 1px solid #f1f5f9; background: white;">
                        <h3 class="card-title" style="margin: 0;">
                            <span class="icon-bg" style="background: #f0fff4; color: #276749;">✈️</span> In Programma
                        </h3>
                    </div>

                    @if ($activeReservations->isEmpty())
                        <div style="text-align: center; padding: 60px 20px; color: #a0aec0;">
                            <div style="font-size: 3rem; margin-bottom: 10px;">🧳</div>
                            <p style="font-size: 1.1rem;">Non hai viaggi futuri in programma.</p>
                            <a href="{{ route('home') }}" class="btn-link">Prenota il tuo prossimo viaggio &rarr;</a>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                                <thead>
                                    <tr
                                        style="background-color: #f8fafc; color: #64748b; font-size: 0.8rem; text-transform: uppercase; text-align: left; letter-spacing: 0.5px;">
                                        <th style="padding: 15px 25px;">Hotel</th>
                                        <th style="padding: 15px;">Date</th>
                                        <th style="padding: 15px;">Info</th>
                                        <th style="padding: 15px 25px; text-align: right;">Gestisci</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activeReservations as $res)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 20px 25px;">
                                                <div style="font-weight: 800; color: #2d3748; font-size: 1rem;">
                                                    {{ $res->hotel->name }}</div>
                                                <div style="font-size: 0.85rem; color: #718096; margin-top: 4px;">📍
                                                    {{ $res->hotel->city }}</div>
                                            </td>

                                            <td style="padding: 20px 15px;">
                                                <div style="font-weight: 600; color: #4a5568;">
                                                    {{ $res->check_in->format('d/m') }} <span
                                                        style="color: #cbd5e0; margin: 0 5px;">➝</span>
                                                    {{ $res->check_out->format('d/m/Y') }}
                                                </div>

                                                @php $hoursLeft = now()->diffInHours($res->check_in, false); @endphp
                                                @if ($hoursLeft > 24)
                                                    <div
                                                        style="font-size: 0.8rem; color: #38a169; margin-top: 4px; font-weight: 600;">
                                                        Tra {{ ceil($hoursLeft / 24) }} giorni
                                                    </div>
                                                @else
                                                    <div
                                                        style="font-size: 0.8rem; color: #e53e3e; margin-top: 4px; font-weight: 600;">
                                                        In partenza!
                                                    </div>
                                                @endif
                                            </td>

                                            <td style="padding: 20px 15px;">
                                                <span style="font-weight: 800; color: #059669; font-size: 1.1rem;">
                                                    €
                                                    {{ number_format($res->total_price ?? $res->hotel->price * $res->check_in->diffInDays($res->check_out), 2) }}
                                                </span>
                                            </td>

                                            <td style="padding: 20px 25px; text-align: right;">
                                                @if ($hoursLeft >= 24)
                                                    <form action="{{ route('reservation.cancel', $res->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Sicuro di voler annullare?');">
                                                        @csrf @method('DELETE')
                                                        <button class="btn-small-danger">❌ Annulla</button>
                                                    </form>
                                                @else
                                                    <span
                                                        style="font-size: 0.75rem; color: #cbd5e0; border: 1px solid #e2e8f0; padding: 5px 8px; border-radius: 6px; cursor: not-allowed;">
                                                        🔒 Non annullabile
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                @if ($pastReservations->isNotEmpty())
                    <div class="card-box"
                        style="padding: 30px; background-color: #f8fafc; border: 1px dashed #cbd5e0; opacity: 0.9;">
                        <h3 class="card-title" style="margin-bottom: 20px; font-size: 1rem; color: #64748b;">
                            📜 Storico Soggiorni Passati
                        </h3>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($pastReservations as $res)
                                <li
                                    style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                    <span>
                                        <strong>{{ $res->hotel->name }}</strong>
                                        <span style="font-size: 0.85rem;">({{ $res->hotel->city }})</span>
                                    </span>
                                    <span style="font-size: 0.85rem;">{{ $res->check_in->format('d/m/Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        /* LAYOUT A GRIGLIA */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            /* Mobile first */
            gap: 30px;
            align-items: start;
        }

        @media (min-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 350px 1fr;
                gap: 40px;
            }
        }

        /* CARDS */
        .card-box {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 30px;
            border: 1px solid #edf2f7;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .icon-bg {
            background: #ebf8ff;
            padding: 8px 10px;
            border-radius: 10px;
            margin-right: 12px;
            font-size: 1.2rem;
            color: #2b6cb0;
        }

        /* INPUT */
        .modern-input {
            width: 100%;
            padding: 12px 15px;
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
            margin-bottom: 8px;
            color: #4a5568;
            font-size: 0.9rem;
        }

        /* BOTTONI */
        .btn-primary {
            background-color: #3182ce;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s;
            font-size: 1rem;
        }

        .btn-primary:hover {
            background-color: #2c5282;
            transform: translateY(-1px);
        }

        .btn-danger {
            width: 100%;
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 10px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.9rem;
        }

        .btn-danger:hover {
            background: #fed7d7;
        }

        .btn-link {
            background: #3182ce;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            display: inline-block;
            margin-top: 15px;
            transition: 0.2s;
        }

        .btn-link:hover {
            background-color: #2c5282;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(49, 130, 206, 0.2);
        }

        .btn-small-danger {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .btn-small-danger:hover {
            background: #fed7d7;
        }
    </style>
</x-app-layout>
