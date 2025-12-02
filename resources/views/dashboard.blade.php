<x-app-layout>
    <div class="page-container">

        <div class="page-header">
            <h1 class="page-title">Ciao, {{ Auth::user()->name }} 👋</h1>
            <p class="page-subtitle">Gestisci il tuo profilo e i tuoi viaggi.</p>
        </div>

        @if (session('success'))
            <div class="alert-box alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-box alert-error">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <div class="dashboard-grid">

            <!-- CARD PROFILO -->
            <div class="card-box profile-card">
                <h3 class="card-title">
                    <span class="icon-bg">👤</span> I tuoi Dati
                </h3>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="input-label">Nome Completo</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required
                            class="modern-input">
                    </div>

                    <div class="form-group">
                        <label class="input-label">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                            class="modern-input">
                    </div>

                    <div class="password-section">
                        <p class="password-title">🔒 Cambio Password</p>

                        <div class="form-group" style="margin-bottom: 12px;">
                            <input type="password" name="password" placeholder="Nuova Password" class="modern-input">
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Conferma Password"
                                class="modern-input">
                        </div>
                    </div>

                    <button class="btn-primary" style="width: 100%;">Salva Modifiche</button>
                </form>

                <div class="delete-account-section">
                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('SEI SICURO? Questa azione è irreversibile.');">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger">🗑️ Elimina Account</button>
                    </form>
                </div>
            </div>

            <!-- CARD PRENOTAZIONI -->
            <div style="display: flex; flex-direction: column; gap: 30px;">

                <div class="card-box" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                    <div class="reservations-card-header">
                        <h3 class="card-title" style="margin: 0;">
                            <span class="icon-bg" style="background: #f0fff4; color: #276749;">✈️</span> In Programma
                        </h3>
                    </div>

                    @if ($activeReservations->isEmpty())
                        <div class="empty-state">
                            <div style="font-size: 3rem; margin-bottom: 10px;">🧳</div>
                            <p style="font-size: 1.1rem;">Non hai viaggi futuri in programma.</p>
                            <a href="{{ route('home') }}" class="btn-link">Prenota il tuo prossimo viaggio &rarr;</a>
                        </div>
                    @else
                        <div class="table-wrapper">
                            <table class="res-table">
                                <thead>
                                    <tr>
                                        <th>Hotel</th>
                                        <th>Date</th>
                                        <th>Info</th>
                                        <th style="text-align: right;">Gestisci</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activeReservations as $res)
                                        <tr>
                                            <td>
                                                <div class="hotel-name">{{ $res->hotel->name }}</div>
                                                <div class="hotel-location">📍 {{ $res->hotel->city }}</div>
                                            </td>

                                            <td style="padding: 20px 15px;">
                                                <div class="date-range">
                                                    {{ $res->check_in->format('d/m') }} <span
                                                        style="color: #cbd5e0; margin: 0 5px;">➝</span>
                                                    {{ $res->check_out->format('d/m/Y') }}
                                                </div>

                                                @php $hoursLeft = now()->diffInHours($res->check_in, false); @endphp
                                                @if ($hoursLeft > 24)
                                                    <div class="days-left-green">Tra {{ ceil($hoursLeft / 24) }} giorni
                                                    </div>
                                                @else
                                                    <div class="days-left-red">In partenza!</div>
                                                @endif
                                            </td>

                                            <td style="padding: 20px 15px;">
                                                <span class="price-tag">
                                                    €
                                                    {{ number_format($res->total_price ?? $res->hotel->price * $res->check_in->diffInDays($res->check_out), 2) }}
                                                </span>
                                            </td>

                                            <td style="text-align: right;">
                                                @if ($hoursLeft >= 24)
                                                    <form action="{{ route('reservation.cancel', $res->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Sicuro di voler annullare?');">
                                                        @csrf @method('DELETE')
                                                        <button class="btn-small-danger">❌ Annulla</button>
                                                    </form>
                                                @else
                                                    <span class="badge-locked">🔒 Non annullabile</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- STORICO -->
                @if ($pastReservations->isNotEmpty())
                    <div class="card-box past-reservations-box">
                        <h3 class="card-title" style="margin-bottom: 20px; font-size: 1rem; color: #64748b;">
                            📜 Storico Soggiorni Passati
                        </h3>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($pastReservations as $res)
                                <li class="past-list-item">
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

    {{-- Questo stile interno lo manteniamo per le griglie e componenti specifici che richiedono media queries --}}
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            align-items: start;
        }

        @media (min-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 350px 1fr;
                gap: 40px;
            }
        }

        /* Le classi card-box, input etc le ho tenute nel CSS esterno o qui se specifiche */
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
