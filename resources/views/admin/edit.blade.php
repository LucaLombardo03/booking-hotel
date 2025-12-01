<x-app-layout>
    <div class="container">
        <div style="margin-bottom: 20px;">
            <a href="{{ route('admin.home') }}" style="color: #3498db; text-decoration: none;">&larr; Torna alla
                Dashboard</a>
        </div>

        <div class="card">
            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">✏️ Modifica Hotel:
                {{ $hotel->name }}</h3>

            <form action="{{ route('admin.hotel.update', $hotel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 3;">
                        <label style="font-weight: bold; font-size: 0.9em;">Nome Hotel</label>
                        <input type="text" name="name" value="{{ $hotel->name }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold; font-size: 0.9em;">Prezzo (€)</label>
                        <input type="number" name="price" value="{{ $hotel->price }}" required>
                    </div>
                </div>

                <div style="display:flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 3;">
                        <label style="font-weight: bold; font-size: 0.9em;">Via / Piazza</label>
                        <input type="text" name="street" value="{{ $hotel->street }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold; font-size: 0.9em;">N. Civico</label>
                        <input type="text" name="house_number" value="{{ $hotel->house_number }}" required>
                    </div>
                </div>

                <div style="display:flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 3;">
                        <label style="font-weight: bold; font-size: 0.9em;">Città</label>
                        <input type="text" name="city" value="{{ $hotel->city }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold; font-size: 0.9em;">CAP</label>
                        <input type="text" name="zip_code" value="{{ $hotel->zip_code }}" required>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; font-size: 0.9em;">Descrizione</label>
                    <textarea name="description" style="height: 80px;">{{ $hotel->description }}</textarea>
                </div>

                <button class="btn" style="background-color: #f39c12; width: 100%;">Salva Modifiche</button>
            </form>
        </div>
    </div>
</x-app-layout>
