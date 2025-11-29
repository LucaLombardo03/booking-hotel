<x-app-layout>
    <div class="container card">
        <h1>Utenti Registrati</h1>
        <a href="{{ route('admin.home') }}">Indietro</a>
        <ul>
            @foreach($users as $user)
                <li>{{ $user->name }} ({{ $user->email }}) - Ruolo: {{ $user->role }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>