<x-guest-layout>
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #2c3e50;">Accedi</h2>
        <p style="color: #7f8c8d; font-size: 0.9em;">Inserisci le tue credenziali</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <x-input-error :messages="$errors->get('email')" style="color: red; font-size: 0.8em; margin-top: 5px;" />
        </div>

        <div style="margin-top: 15px;">
            <label for="password" style="display: block; font-weight: bold; margin-bottom: 5px;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <x-input-error :messages="$errors->get('password')" style="color: red; font-size: 0.8em; margin-top: 5px;" />
        </div>

        <div style="display: flex; align-items: center; margin-top: 15px; margin-bottom: 20px;">
            <input id="remember_me" type="checkbox" name="remember"
                style="width: auto; margin-right: 10px; cursor: pointer;">
            <label for="remember_me" style="font-size: 0.9em; color: #666; cursor: pointer;">Ricordami</label>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    style="font-size: 0.9em; color: #3498db; text-decoration: none;">
                    Password dimenticata?
                </a>
            @endif

            <button type="submit" class="btn"
                style="background: #2c3e50; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>
