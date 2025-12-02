<x-app-layout>
    <div class="page-container" style="max-width: 1000px;">

        <div class="page-header">
            <h1 class="page-title">Gestione Utenti</h1>
            <a href="{{ route('admin.home') }}" class="back-link">&larr; Torna alla Dashboard</a>
        </div>

        @if (session('success'))
            <div class="alert-box alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="card-box">
            @if ($users->isEmpty())
                <p>Nessun utente registrato.</p>
            @else
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Utente</th>
                            <th>Ruolo</th>
                            <th>Registrato il</th>
                            <th style="text-align: right;">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div style="font-weight: bold; color: #2d3748;">{{ $user->name }}</div>
                                    <div style="font-size: 0.9rem; color: #718096;">{{ $user->email }}</div>
                                </td>
                                <td>
                                    @if ($user->role === 'admin')
                                        <span class="badge-admin">ADMIN</span>
                                    @else
                                        <span class="badge-user">USER</span>
                                    @endif
                                </td>
                                <td style="color: #4a5568;">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn-action btn-action-edit">Modifica</a>

                                        @if (Auth::id() !== $user->id)
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Sicuro?');">
                                                @csrf @method('DELETE')
                                                <button class="btn-action btn-action-delete">Elimina</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
