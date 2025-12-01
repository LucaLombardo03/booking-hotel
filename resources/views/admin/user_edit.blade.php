<x-app-layout>
    <div class="container" style="max-width: 600px;">
        <div style="margin-bottom: 20px;">
            <a href="{{ route('admin.users') }}" style="color: #3498db; text-decoration: none;">&larr; Torna alla Lista
                Utenti</a>
        </div>

        <div class="card">
            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">✏️ Modifica Utente:
                {{ $user->name }}</h3>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nome</label>
                    <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required style="width: 100%;">
                </div>

                <div style="margin-bottom: 20px; background: #fff3cd; padding: 15px; border-radius: 5px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #856404;">⚠️ Reset
                        Password (Opzionale)</label>
                    <p style="font-size: 0.8em; color: #666; margin-bottom: 10px;">Inserisci una password qui sotto SOLO
                        se vuoi cambiarla all'utente. Altrimenti lascia vuoto.</p>
                    <input type="text" name="password" placeholder="Nuova Password..." style="width: 100%;">
                </div>

                <button class="btn" style="background-color: #f39c12; width: 100%;">Salva Modifiche Utente</button>
            </form>
        </div>
    </div>
</x-app-layout>
