<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Importante per la password

class HotelController extends Controller
{
    // --- PARTE PUBBLICA ---

    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->has('search') && $request->search != '') {
            $s = $request->get('search');
            // Cerca se la stringa è contenuta nel NOME oppure nella CITTÀ
            $query->where('name', 'LIKE', "%{$s}%")
                ->orWhere('city', 'LIKE', "%{$s}%");
        }

        $hotels = $query->paginate(6);

        return view('welcome', compact('hotels'));
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);

        // Recupera le date già prenotate (future) per mostrarle nel calendario/lista
        $bookedDates = Reservation::where('hotel_id', $id)
            ->where('check_out', '>=', now())
            ->orderBy('check_in')
            ->get();

        return view('hotel_detail', compact('hotel', 'bookedDates'));
    }

    // --- PARTE UTENTE LOGGATO ---

    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Recupera TUTTE le prenotazioni dell'utente
        $allReservations = Reservation::where('user_id', $user->id)
            ->with('hotel')
            ->orderBy('check_in', 'asc') // Ordine cronologico
            ->get();

        // Separa in due gruppi usando la data di oggi
        // Attive: Il Check-out è nel futuro (o oggi)
        $activeReservations = $allReservations->where('check_out', '>=', now()->startOfDay());

        // Passate: Il Check-out è già passato
        $pastReservations = $allReservations->where('check_out', '<', now()->startOfDay())->sortByDesc('check_in'); // Le passate le ordiniamo dalla più recente

        return view('dashboard', compact('activeReservations', 'pastReservations'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profilo aggiornato con successo!');
    }

    public function storeReservation(Request $request)
    {
        // 1. Validazione con messaggi in Italiano
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ], [
            'check_in.after' => 'Il check-in deve essere una data futura.',
            'check_out.after' => 'La data di check-out deve essere successiva al check-in.',
        ]);

        // 2. Controllo sovrapposizione date
        $exists = Reservation::where('hotel_id', $request->hotel_id)
            ->where(function ($query) use ($request) {
                $query->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Ci dispiace, queste date sono già occupate per questo hotel.']);
        }

        // --- NUOVA PARTE: CALCOLO PREZZO ---

        // A. Recupera dati Hotel
        $hotel = Hotel::findOrFail($request->hotel_id);

        // B. Calcola i giorni (usando Carbon)
        $start = \Carbon\Carbon::parse($request->check_in);
        $end = \Carbon\Carbon::parse($request->check_out);
        $days = $start->diffInDays($end);

        // C. Calcola Totale: (Prezzo * Giorni) + (Tassa * Giorni)
        // Se la tassa è null, usa 0
        $tax = $hotel->tourist_tax ?? 0;
        $totalPrice = ($hotel->price * $days) + ($tax * $days);

        // -----------------------------------

        // 3. Creazione prenotazione (con il prezzo totale)
        Reservation::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice // <--- SALVIAMO IL TOTALE QUI
        ]);

        return redirect()->route('dashboard')->with('success', 'Prenotazione confermata! Totale pagato: € ' . number_format($totalPrice, 2));
    }

    public function cancelReservation($id)
    {
        // Trova la prenotazione (assicurandoci che sia DELL'UTENTE loggato per sicurezza)
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // --- TOCCO DI CLASSE: Controllo 24 Ore ---
        // Calcoliamo la differenza in ore tra ADESSO e il CHECK-IN
        $hoursUntilCheckIn = now()->diffInHours($reservation->check_in, false); // false serve per avere numeri negativi se è passato

        if ($hoursUntilCheckIn < 24) {
            return back()->withErrors(['error' => 'Troppo tardi! Puoi cancellare solo fino a 24 ore prima del check-in.']);
        }
        // ----------------------------------------

        $reservation->delete();

        return back()->with('success', 'Prenotazione cancellata correttamente.');
    }

    // --- PARTE AMMINISTRATORE ---

    public function adminHome()
    {
        $hotels = Hotel::withCount('reservations')->get();
        return view('admin.home', compact('hotels'));
    }

    public function adminUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    public function storeHotel(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'house_number' => 'required',
            'zip_code' => 'required',
            'price' => 'required|numeric',
            // Validazione: deve essere numero, ma è opzionale (nullable)
            'tourist_tax' => 'nullable|numeric|min:0'
        ]);

        Hotel::create($request->all());
        return back()->with('success', 'Hotel aggiunto');
    }

    public function deleteHotel($id)
    {
        Hotel::destroy($id);
        return back()->with('success', 'Hotel rimosso');
    }

    // 1. Mostra il form di modifica con i dati già inseriti
    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.edit', compact('hotel'));
    }

    // 2. Salva le modifiche
    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'house_number' => 'required',
            'zip_code' => 'required',
            'price' => 'required|numeric',
            // Aggiungi anche qui
            'tourist_tax' => 'nullable|numeric|min:0'
        ]);

        $hotel->update($request->all());
        return redirect()->route('admin.home')->with('success', 'Hotel modificato!');
    }

    // --- GESTIONE UTENTI (ADMIN) ---

    // 1. Mostra il form di modifica utente
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_edit', compact('user'));
    }

    // 2. Salva le modifiche all'utente
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Ignora l'email dell'utente attuale nel controllo unique
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8', // Password opzionale
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Aggiorna la password SOLO se è stata scritta
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Utente aggiornato con successo!');
    }

    // 3. Elimina l'utente
    public function deleteUser($id)
    {
        // Impedisci all'admin di cancellarsi da solo!
        if (Auth::id() == $id) {
            return back()->withErrors(['error' => 'Non puoi cancellare te stesso!']);
        }

        User::destroy($id);
        return back()->with('success', 'Utente eliminato.');
    }
}
