<x-guest-layout>
    <div style="max-width: 450px; margin: 0 auto; padding-top: 40px; padding-bottom: 40px;">

        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #2d3748; margin: 0;">Benvenuto! 👋</h1>
            <p style="color: #718096; margin-top: 10px;">Crea un account per iniziare a prenotare.</p>
        </div>

        <div
            style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: bold; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem;">Nome
                        Completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        autocomplete="name"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; font-size: 1rem; box-sizing: border-box;">
                    <x-input-error :messages="$errors->get('name')" style="color: #e53e3e; font-size: 0.85rem; margin-top: 5px;" />
                </div>

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: bold; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; font-size: 1rem; box-sizing: border-box;">
                    <x-input-error :messages="$errors->get('email')" style="color: #e53e3e; font-size: 0.85rem; margin-top: 5px;" />
                </div>

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: bold; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem;">Password</label>
                    <input type="password" name="password" required autocomplete="new-password"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; font-size: 1rem; box-sizing: border-box;">
                    <x-input-error :messages="$errors->get('password')" style="color: #e53e3e; font-size: 0.85rem; margin-top: 5px;" />
                </div>

                <div style="margin-bottom: 30px;">
                    <label
                        style="display: block; font-weight: bold; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem;">Conferma
                        Password</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; font-size: 1rem; box-sizing: border-box;">
                    <x-input-error :messages="$errors->get('password_confirmation')" style="color: #e53e3e; font-size: 0.85rem; margin-top: 5px;" />
                </div>

                <button
                    style="width: 100%; background: #2d3748; color: white; padding: 15px; border-radius: 10px; font-weight: bold; border: none; cursor: pointer; font-size: 1rem; transition: background 0.2s;">
                    Registrati
                </button>

                <div style="text-align: center; margin-top: 25px; font-size: 0.9rem; color: #718096;">
                    Hai già un account? <a href="{{ route('login') }}"
                        style="color: #3182ce; font-weight: bold; text-decoration: none;">Accedi qui</a>
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
            text-decoration: underline !important;
        }
    </style>
</x-guest-layout>
