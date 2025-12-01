<x-app-layout>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>👥 Gestione Utenti</h1>
            <a href="{{ route('admin.home') }}" style="color: #3498db; text-decoration: none;">&larr; Torna alla
                Dashboard</a>
        </div>

        <div class="card">
            @if ($users->isEmpty())
                <p>Nessun utente registrato.</p>
            @else
                <table>
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ruolo</th>
                            <th>Iscritto il</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td style="font-weight: bold;">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role === 'admin')
                                        <span
                                            style="background-color: #e2e8f0; padding: 2px 6px; border-radius: 4px; font-size: 0.8em; font-weight: bold;">ADMIN</span>
                                    @else
                                        <span style="color: #666;">User</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn"
                                            style="background: #f39c12; padding: 5px 10px; font-size: 0.8em; color: white; border-radius: 4px;">
                                            Modifica
                                        </a>

                                        @if (Auth::id() !== $user->id)
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Sei sicuro di voler eliminare questo utente? Verranno cancellate anche le sue prenotazioni.');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn"
                                                    style="background: #e74c3c; padding: 5px 10px; font-size: 0.8em; margin: 0;">Elimina</button>
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
