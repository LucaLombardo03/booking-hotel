<x-app-layout>
    <div style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a202c; margin: 0;">Gestione Utenti</h1>
            <a href="{{ route('admin.home') }}" style="color: #718096; text-decoration: none; font-weight: bold;">&larr;
                Torna alla Dashboard</a>
        </div>

        <div
            style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #edf2f7;">

            @if ($users->isEmpty())
                <p>Nessun utente registrato.</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #edf2f7;">
                            <th
                                style="text-align: left; padding: 15px; color: #718096; font-size: 0.85rem; text-transform: uppercase;">
                                Utente</th>
                            <th
                                style="text-align: left; padding: 15px; color: #718096; font-size: 0.85rem; text-transform: uppercase;">
                                Ruolo</th>
                            <th
                                style="text-align: left; padding: 15px; color: #718096; font-size: 0.85rem; text-transform: uppercase;">
                                Registrato il</th>
                            <th
                                style="text-align: right; padding: 15px; color: #718096; font-size: 0.85rem; text-transform: uppercase;">
                                Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 15px;">
                                    <div style="font-weight: bold; color: #2d3748;">{{ $user->name }}</div>
                                    <div style="font-size: 0.9rem; color: #718096;">{{ $user->email }}</div>
                                </td>
                                <td style="padding: 15px;">
                                    @if ($user->role === 'admin')
                                        <span
                                            style="background: #2d3748; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold;">ADMIN</span>
                                    @else
                                        <span
                                            style="background: #edf2f7; color: #4a5568; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold;">USER</span>
                                    @endif
                                </td>
                                <td style="padding: 15px; color: #4a5568;">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: 15px; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            style="background: #ecc94b; color: #744210; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: bold; text-decoration: none;">Modifica</a>

                                        @if (Auth::id() !== $user->id)
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Sicuro?');">
                                                @csrf @method('DELETE')
                                                <button
                                                    style="background: #fc8181; color: white; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: bold; border: none; cursor: pointer;">Elimina</button>
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