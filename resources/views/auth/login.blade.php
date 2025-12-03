<x-guest-layout>
    <div style="max-width: 450px; margin: 0 auto; padding-top: 50px; padding-bottom: 40px;">

        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #2d3748; margin: 0;">Bentornato! 👋</h1>
            <p style="color: #718096; margin-top: 10px;">Accedi per gestire le tue prenotazioni.</p>
        </div>

        <div
            style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: bold; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; font-size: 1rem; box-sizing: border-box;">
                    <x-input-error :messages="$errors->get('email')" style="color: #e53e3e; font-size: 0.85rem; margin-top: 5px;" />
                </div>

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: bold; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem;">Password</label>
                    <input type="password" name="password" required autocomplete="current-password"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; font-size: 1rem; box-sizing: border-box;">
                    <x-input-error :messages="$errors->get('password')" style="color: #e53e3e; font-size: 0.85rem; margin-top: 5px;" />
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <label for="remember_me" style="display: flex; align-items: center; cursor: pointer;">
                        <input id="remember_me" type="checkbox" name="remember"
                            style="border-radius: 4px; border: 1px solid #cbd5e0; text-color: #3182ce; width: 16px; height: 16px; cursor: pointer;">
                        <span
                            style="margin-left: 8px; color: #4a5568; font-size: 0.9rem; font-weight: 600;">Ricordami</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            style="text-align: right; color: #3182ce; font-size: 0.9rem; font-weight: bold; text-decoration: none; transition: color 0.2s;">
                            Password dimenticata?
                        </a>
                    @endif
                </div>

                <button
                    style="width: 100%; background: #2d3748; color: white; padding: 15px; border-radius: 10px; font-weight: bold; border: none; cursor: pointer; font-size: 1rem; transition: background 0.2s;">
                    Accedi
                </button>

                <div style="text-align: center; margin-top: 25px; font-size: 0.9rem; color: #718096;">
                    Non hai un account? <a href="{{ route('register') }}"
                        style="color: #3182ce; font-weight: bold; text-decoration: none; transition: color 0.2s;">Registrati
                        qui</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3182ce !important;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        button:hover {
            background-color: #1a202c !important;
        }

        a:hover {
            color: #2c5282 !important;
            text-decoration: underline !important;
        }

        /* Stile extra per la checkbox per renderla più carina se il browser lo supporta */
        input[type="checkbox"]:checked {
            background-color: #3182ce;
            border-color: #3182ce;
        }
    </style>
</x-guest-layout>
