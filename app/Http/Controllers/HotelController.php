<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    // --- PARTE PUBBLICA (HOME) --

    public function index(Request $request)
    {
        $query = Hotel::query();

        // 1. Logica di Ricerca
        if ($request->has('search') && $request->search != '') {
            $s = $request->get('search');

            // Filtra per nome o città
            $query->where(function ($q) use ($s) {
                $q->where('name', 'LIKE', "%{$s}%")
                    ->orWhere('city', 'LIKE', "%{$s}%");
            });
        }

        // 2. Logica di Ordinamento (FILTRI PREZZO)
        // Questo è il pezzo che mancava per ordinare
        if ($request->has('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc'); // Prezzo Crescente
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc'); // Prezzo Decrescente
            }
        }

        // Paginazione
        $hotels = $query->paginate(6);

        return view('welcome', compact('hotels'));
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);

        // Recupera le date già prenotate (future)
        $bookedDates = Reservation::where('hotel_id', $id)
            ->where('check_out', '>=', now())
            ->orderBy('check_in')
            ->get();

        return view('hotel_detail', compact('hotel', 'bookedDates'));
    }

    // --- PARTE UTENTE LOGGATO (DASHBOARD) ---

    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Recupera TUTTE le prenotazioni dell'utente
        $allReservations = Reservation::where('user_id', $user->id)
            ->with('hotel')
            ->orderBy('check_in', 'asc') // Ordine cronologico
            ->get();

        // Separa in due gruppi: Future e Passate
        $activeReservations = $allReservations->where('check_out', '>=', now()->startOfDay());
        $pastReservations = $allReservations->where('check_out', '<', now()->startOfDay())->sortByDesc('check_in');

        return view('dashboard', compact('activeReservations', 'pastReservations'));
    }

    // Aggiornamento Profilo
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

    // Cancellazione Account (Utente si cancella da solo)
    public function destroyProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        Auth::logout(); // Logout prima di cancellare

        $user->delete(); // Cancella utente (e prenotazioni a cascata)

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Il tuo account è stato eliminato.');
    }

    // Salva Prenotazione
    public function storeReservation(Request $request)
    {
        // 1. Validazione
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ], [
            'check_in.after' => 'Il check-in deve essere una data futura.',
            'check_out.after' => 'La data di check-out deve essere successiva al check-in.',
        ]);

        // 2. Controllo sovrapposizione
        $exists = Reservation::where('hotel_id', $request->hotel_id)
            ->where(function ($query) use ($request) {
                $query->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Ci dispiace, queste date sono già occupate per questo hotel.']);
        }

        // 3. Calcolo Totale
        $hotel = Hotel::findOrFail($request->hotel_id);
        $start = \Carbon\Carbon::parse($request->check_in);
        $end = \Carbon\Carbon::parse($request->check_out);
        $days = $start->diffInDays($end);

        $tax = $hotel->tourist_tax ?? 0;
        $totalPrice = ($hotel->price * $days) + ($tax * $days);

        // 4. Creazione prenotazione
        Reservation::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice
        ]);

        return redirect()->route('dashboard')->with('success', 'Prenotazione confermata! Totale: € ' . number_format($totalPrice, 2));
    }

    // Cancella Prenotazione (Controllo 24 ore)
    public function cancelReservation($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $hoursUntilCheckIn = now()->diffInHours($reservation->check_in, false);

        if ($hoursUntilCheckIn < 24) {
            return back()->withErrors(['error' => 'Troppo tardi! Puoi cancellare solo fino a 24 ore prima del check-in.']);
        }

        $reservation->delete();

        return back()->with('success', 'Prenotazione cancellata correttamente.');
    }

    // --- PARTE AMMINISTRATORE (HOTEL) ---

    public function adminHome()
    {
        $hotels = Hotel::withCount('reservations')->get();
        return view('admin.home', compact('hotels'));
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
            'tourist_tax' => 'nullable|numeric|min:0'
        ]);

        Hotel::create($request->all());
        return back()->with('success', 'Hotel aggiunto');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.edit', compact('hotel'));
    }

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
            'tourist_tax' => 'nullable|numeric|min:0'
        ]);

        $hotel->update($request->all());
        return redirect()->route('admin.home')->with('success', 'Hotel modificato!');
    }

    public function deleteHotel($id)
    {
        Hotel::destroy($id);
        return back()->with('success', 'Hotel rimosso');
    }

    // --- GESTIONE UTENTI (ADMIN) ---

    public function adminUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Utente aggiornato con successo!');
    }

    public function deleteUser($id)
    {
        if (Auth::id() == $id) {
            return back()->withErrors(['error' => 'Non puoi cancellare te stesso!']);
        }

        User::destroy($id);
        return back()->with('success', 'Utente eliminato.');
    }
}
