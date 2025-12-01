<x-guest-layout>
    <div style="max-width: 450px; margin: 0 auto; padding-top: 50px;">

        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 1.8rem; font-weight: 800; color: #2d3748;">Recupera Password</h1>
            <p style="color: #718096; margin-top: 10px; font-size: 0.95rem; line-height: 1.5;">
                Hai dimenticato la password? Nessun problema.<br>
                Inserisci la tua email e ti invieremo un link per crearne una nuova.
            </p>
        </div>

        <div
            style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);">

            @if (session('status'))
                <div
                    style="background-color: #f0fff4; color: #276749; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #c6f6d5; text-align: center; font-weight: bold; font-size: 0.9rem;">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: bold; color: #4a5568; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; font-size: 1rem; box-sizing: border-box;">
                    <x-input-error :messages="$errors->get('email')" style="color: #e53e3e; font-size: 0.85rem; margin-top: 5px;" />
                </div>

                <button
                    style="width: 100%; background: #2d3748; color: white; padding: 15px; border-radius: 10px; font-weight: bold; border: none; cursor: pointer; font-size: 1rem; transition: background 0.2s;">
                    Invia Link di Reset
                </button>

                <div style="text-align: center; margin-top: 25px;">
                    <a href="{{ route('login') }}"
                        style="color: #718096; text-decoration: none; font-size: 0.9rem; font-weight: bold;">
                        &larr; Torna al Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        input:focus {
            border-color: #3182ce !important;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        button:hover {
            background-color: #1a202c !important;
        }

        a:hover {
            color: #3182ce !important;
        }
    </style>
</x-guest-layout>
