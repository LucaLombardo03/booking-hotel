<x-app-layout>
    <div class="page-container" style="max-width: 600px;">
        <div class="page-header">
            <h1 class="page-title">Modifica Utente</h1>
            <a href="{{ route('admin.users') }}" class="back-link">&larr; Torna alla Lista Utenti</a>
        </div>

        <div class="card-box">
            <h3 class="card-title">✏️ Utente: {{ $user->name }}</h3>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 15px;">
                    <label class="input-label">Nome</label>
                    <input type="text" name="name" value="{{ $user->name }}" required class="modern-input">
                </div>

                <div style="margin-bottom: 15px;">
                    <label class="input-label">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="modern-input">
                </div>

                <div class="alert-box" style="background: #fff3cd; border: 1px solid #ffeeba; margin-top: 20px;">
                    <label class="input-label" style="color: #856404;">⚠️ Reset Password (Opzionale)</label>
                    <p style="font-size: 0.8em; color: #666; margin-bottom: 10px;">Inserisci una password qui sotto SOLO
                        se vuoi cambiarla all'utente. Altrimenti lascia vuoto.</p>
                    <input type="text" name="password" placeholder="Nuova Password..." class="modern-input">
                </div>

                <button class="btn-save" style="width: 100%;">Salva Modifiche Utente</button>
            </form>
        </div>
    </div>
</x-app-layout>
